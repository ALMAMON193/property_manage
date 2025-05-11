<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\KeyFeature;
use App\Models\Product;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class FilterApiController extends Controller
{
    use ResponseTrait;

    /*=========== GET CATEGORIES ==============*/
    public function getCategories()
    {
        $categories = Category::pluck('id','name');

        $response = $categories->map(function ($id, $category) {
            return [
                'id' => $id,
                'category_name' => $category,
            ];
        })->values();

        $message = 'All calibers retrieved successfully';


        return $this->sendResponse($response, $message);
    }

    /*======================== get all and category wise calibers ==========================*/
    public function getCalibers($category_id = null)
    {
        // Check if a specific category_id is provided
        if ($category_id) {
            // Validate if the category_id exists
            $category = Category::find($category_id);

            if (!$category) {
                return $this->sendError('Category not found.', []);
            }

            // Fetch calibers for the specific category
            $calibers = KeyFeature::where('category_id', $category_id)
                ->pluck('id','caliber');

            $response = $calibers->map(function ($id, $caliber) {
                return [
                    'id' => $id,
                    'caliber' => $caliber,
                ];
            })->values();

            $message = 'Category-wise calibers retrieved successfully';

            return $this->sendResponse($response, $message);
        }

        // If no category_id is provided, fetch all calibers
        $calibers = KeyFeature::pluck('id','caliber');

        $response = $calibers->map(function ($id, $caliber) {
            return [
                'id' => $id,
                'caliber' => $caliber,
            ];
        })->values();

        $message = 'All calibers retrieved successfully';

        return $this->sendResponse($response, $message);
    }



    /*=========== GET BRAND NAME ==============*/
    public function getBrands()
    {
        try {
            $brands = Product::whereNotNull('brand')->distinct()->pluck('brand');

            if ($brands->isEmpty()) {
                return $this->sendResponse($brands, 'No brands were found.');
            }

            return $this->sendResponse($brands, 'Brand names retrieved successfully.');
        } catch (\Exception $e) {
            \Log::error('Error fetching brand names: ' . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return $this->sendError('An error occurred while retrieving brand names.', ['error' => $e->getMessage()], 500);
        }
    }


    /*=========== GET CASINGS ==============*/
    public function getCasings()
    {
        try {
            $brands = Product::whereNotNull('casing')->distinct()->pluck('casing');

            if ($brands->isEmpty()) {
                return $this->sendResponse($brands, 'No casings were found.');
            }

            return $this->sendResponse($brands, 'Casing names retrieved successfully.');
        } catch (\Exception $e) {
            \Log::error('Error fetching casing names: ' . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return $this->sendError('An error occurred while retrieving casing names.', ['error' => $e->getMessage()], 500);
        }
    }


    /*=============== GET GRAINS ==============*/
    public function getGrains()
    {
        try {
            $brands = Product::whereNotNull('grains')->distinct()->pluck('grains');

            if ($brands->isEmpty()) {
                return $this->sendResponse($brands, 'No grains were found.');
            }

            return $this->sendResponse($brands, 'Grains retrieved successfully.');
        } catch (\Exception $e) {
            \Log::error('Error fetching grains: ' . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return $this->sendError('An error occurred while retrieving grains.', ['error' => $e->getMessage()], 500);
        }
    }



    /*=============== FILTER PRODUCT ==============*/
    public function getFilteredProducts(){

    }

}
