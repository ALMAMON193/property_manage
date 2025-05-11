<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\KeyFeature;
use App\Models\Product;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        function normalizeCaliber($caliber)
        {
            return strtolower(str_replace(' ', '', trim($caliber)));
        }

        $products = Product::with([
            'retailer' => function ($query) {
                $query->select('id', 'title', 'retailer_website');
            }
        ])
            ->whereHas('retailer', function ($query) {
                $query->where('status', 'active');
            })
            ->withAvg('productReviews', 'rating')
            ->paginate(100);

        $keyFeatures = KeyFeature::with('category')->get();

        foreach ($products as $product) {
            $normalizedProductCaliber = normalizeCaliber($product->caliber);
            $matchedKeyFeature = null;

            foreach ($keyFeatures as $keyFeature) {
                $caliberNames = explode(';', $keyFeature->caliber_names);

                foreach ($caliberNames as $caliberName) {
                    if ($normalizedProductCaliber === normalizeCaliber($caliberName)) {
                        $matchedKeyFeature = $keyFeature;
                        break 2; // ✅ Found match, exit both loops
                    }
                }
            }

            if ($matchedKeyFeature) {
                // Build full image URL directly from stored path
                if ($matchedKeyFeature->image) {
                    $matchedKeyFeature->image_url = url($matchedKeyFeature->image);
                } else {
                    $matchedKeyFeature->image_url = null;
                }

                $product->key_features = $matchedKeyFeature;
            } else {
                $product->key_features = null;
            }
        }

        $message = 'Products retrieved successfully';

        return $this->sendResponse($products, $message);
    }






    public function productDetails($id)
    {
        // Helper function to normalize caliber
        function normalizeCaliber($caliber)
        {
            return strtolower(str_replace(' ', '', trim($caliber)));
        }

        // Load product with retailer and reviews
        $product = Product::with([
            'retailer' => function ($query) {
                $query->select('id', 'title', 'retailer_website');
            }
        ])
            ->withAvg('productReviews', 'rating')
            ->whereHas('retailer', function ($query) {
                $query->where('status', 'active');
            })
            ->find($id);

        // Check if the product exists
        if (!$product) {
            return $this->sendError('Product not found', [], 404);
        }

        // Load key features with category
        $keyFeatures = KeyFeature::with('category')->get();

        $normalizedProductCaliber = normalizeCaliber($product->caliber);
        $matchedKeyFeature = null;

        foreach ($keyFeatures as $keyFeature) {
            $caliberNames = explode(';', $keyFeature->caliber_names);

            foreach ($caliberNames as $caliberName) {
                if ($normalizedProductCaliber === normalizeCaliber($caliberName)) {
                    $matchedKeyFeature = $keyFeature;
                    break 2;
                }
            }
        }

        if ($matchedKeyFeature) {
            $matchedKeyFeature->image_url = $matchedKeyFeature->image ? url($matchedKeyFeature->image) : null;
            $product->key_features = $matchedKeyFeature;
        } else {
            $product->key_features = null;
        }

        return $this->sendResponse($product, 'Product details retrieved successfully');
    }










}
