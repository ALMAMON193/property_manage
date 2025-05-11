<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactApiController extends Controller
{
    use ResponseTrait;
    public function store(Request $request)
    {
        $rules = [
            'company_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^\+?[1-9]\d{1,14}$/',
            'comment' => 'nullable|string',
            'not_a_robot' => 'required|accepted',
        ];



        $messages = [
            'not_a_robot.required' => 'Please confirm that you are not a robot.',
            'not_a_robot.accepted' => 'Please confirm that you are not a robot.',
        ];

        // Validate the incoming request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors()->toArray(), 422);
        }

        // Create the contact
        $contactData = [
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'comment' => $request->comment,
            'not_a_robot' => $request->not_a_robot,
        ];
        $contact = Contact::create($contactData);

        // Prepare success response
        $success = [];

        // Evaluate the message based on the $isNewUser condition
        $message = 'Contact saved successfully';


        return $this->sendResponse($success, $message);
    }
}
