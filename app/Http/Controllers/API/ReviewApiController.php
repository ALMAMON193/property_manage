<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\ShippingReview;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewApiController extends Controller
{
    use ResponseTrait;

    /*========================= PRODUCT REVIEW =====================*/
    public function postProductReview(Request $request)
    {
        if(!Auth::check()) {
            return $this->sendError('Please login first', [], 422);
        }else{
            $user = Auth::user();
        }

        // Validate the incoming request
        $rules = [
            'product_id' => 'required|exists:products,id',
            'review' => 'nullable|string|max:1000',
        ];
        $messages = [];

        // Validate the incoming request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors()->toArray(), 422);
        }


            // Create or update the review
        $review = ProductReview::updateOrCreate(
            [
                'product_id' => $request->product_id,
                'user_id' => $user->id
            ],
            [
                'review' => $request->review,
            ]
        );


        $message = 'Product review posted successfully.';


        return $this->sendResponse($review, $message);
    } /*=== end postProductReview ===*/


    public function postProductRating(Request $request)
    {
        if(!Auth::check()) {
            return $this->sendError('Please login first', [], 422);
        }else{
            $user = Auth::user();
        }

        // Validate the incoming request
        $rules = [
            'product_id' => 'required|exists:products,id',
            'rating' => 'nullable|integer|min:1|max:5',   // Required rating between 1 and 5
        ];
        $messages = [
            'rating.required' => 'Please provide a rating between 1 and 5 star.',
        ];

        // Validate the incoming request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors()->toArray(), 422);
        }


        // Create or update the review
        $review = ProductReview::updateOrCreate(
            [
                'product_id' => $request->product_id,
                'user_id' => $user->id
            ],
            [
                'rating' => $request->rating,
            ]
        );


        $message = 'Product rating posted successfully.';


        return $this->sendResponse($review, $message);
    }

    public function getProductReview($product_id)
    {
        $reviews = ProductReview::where('product_id', $product_id)
            ->with('user') // Eager load the user relationship
            ->latest()
            ->get()
            ->map(function ($review) {
                // Update the user's image to include the full URL
                if ($review->user && $review->user->image) {
                    $review->user->image = url($review->user->image);
                }

                // Format the updated_at time
                $review->time = $review->updated_at->diffForHumans();

                // Hide created_at and updated_at fields
                return $review->makeHidden(['created_at', 'updated_at']);
            });

        return $this->sendResponse($reviews, 'Product review retrieved successfully.');
    }



    /*========================= SHIPPING REVIEW =====================*/
    public function postShippingReview(Request $request)
    {
        if(!Auth::check()) {
            return $this->sendError('Please login first', [], 422);
        }else{
            $user = Auth::user();
        }
        // Validate the incoming request
        $rules = [
            'product_id' => 'required|exists:products,id',
            'review' => 'nullable|string|max:1000',
        ];
        $messages = [];

        // Validate the incoming request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors()->toArray(), 422);
        }


        // Create or update the review
        $review = ShippingReview::updateOrCreate(
            [
                'product_id' => $request->product_id,
                'user_id' => $user->id,
            ],
            [
                'review' => $request->review,
            ]
        );

        // Return a success response
        $message = 'Product review posted successfully.';


        return $this->sendResponse($review, $message);
    }



    public function postShippingRating(Request $request)
    {
        if(!Auth::check()) {
            return $this->sendError('Please login first', [], 422);
        }else{
            $user = Auth::user();
        }
        // Validate the incoming request
        $rules = [
            'product_id' => 'required|exists:products,id',
            'rating' => 'nullable|integer|min:1|max:5',   // Required rating between 1 and 5
        ];
        $messages = [];

        // Validate the incoming request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors()->toArray(), 422);
        }


        // Create or update the review
        $review = ShippingReview::updateOrCreate(
            [
                'product_id' => $request->product_id,
                'user_id' => $user->id,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        // Return a success response
        $message = 'Product rating posted successfully.';


        return $this->sendResponse($review, $message);
    }

    public function getShippingReview($product_id)
    {
        $reviews = ShippingReview::where('product_id', $product_id)
            ->with('user') // Eager load the user relationship
            ->latest()
            ->get()
            ->map(function ($review) {
                // Update the user's image to include the full URL
                if ($review->user && $review->user->image) {
                    $review->user->image = url($review->user->image);
                }
                // Format the created_at time as relative time (e.g., "4 hours ago")
                $review->time = $review->created_at->diffForHumans();
                // Hide created_at and updated_at fields
                return $review->makeHidden(['created_at', 'updated_at']);
            });

        return $this->sendResponse($reviews, 'Shipping reviews retrieved successfully.');
    }

}
