<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionApiController extends Controller
{
    use ResponseTrait;
    public function store(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:subscriptions,email',
        ];



        // Validate the incoming request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors()->toArray(), 422);
        }

        // Create the contact
        $data = [
            'email' => $request->email,
        ];
        $subscription = Subscription::create($data);

        // Prepare success response
        $success = [];

        // Evaluate the message based on the $isNewUser condition
        $message = 'Subscription saved successfully';

        // Call sendResponse from BaseController and pass the token
        return $this->sendResponse($success, $message);
    }
}
