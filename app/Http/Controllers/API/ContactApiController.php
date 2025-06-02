<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\Contact;
use App\Models\EntityContact;
use App\Models\EntityRepresentative;
use App\Models\User;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ContactApiController extends Controller
{
    use ResponseTrait;
    public function store(Request $request)
    {
        // Check if the user is authenticated via the 'api' guard
        if (!auth('api')->check()) {
            return $this->sendError('Please login first', [], 422);
        }
        $authenticatedUser = auth('api')->user();

        $rules = [
            'type' => 'required|in:individual,legal_entity',
            'category' => 'required|string',
            'salutation' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^\+?[0-9]\d{1,14}$/',
            'date_of_birth' => 'nullable|date_format:m/d/Y',
            'place_of_birth' => 'nullable|string',
            'address_line_1' => 'nullable|string',
            'address_line_2' => 'nullable|string',
            'country' => 'nullable|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'additional_info' => 'nullable|string',
            'entity_id' => 'nullable|exists:entities,id',
            'building_id' => 'nullable|exists:buildings,id',

            // for type legal_entity
            'legal_status' => 'nullable|string',
            'company_name' => 'nullable|string',

            //for bank
            'bank_name' => 'nullable|string',
            'rib_iban' => 'nullable|string',
            'bic_swift' => 'nullable|string',
            'bank_address_line_1' => 'nullable|string',
            'bank_address_line_2' => 'nullable|string',
            'bank_country' => 'nullable|string',
            'bank_city' => 'nullable|string',
            'bank_postal_code' => 'nullable|string',

            //for representative
            'r_salutation' => 'nullable|string',
            'r_first_name' => 'nullable|string',
            'r_last_name' => 'nullable|string',
            'quality' => 'nullable|string',
            'r_email' => 'required_if:type,legal_entity|email',
            'r_phone' => 'nullable|string|regex:/^\+?[0-9]\d{1,14}$/',
            'r_date_of_birth' => 'nullable|date|date_format:m/d/Y',
            'r_place_of_birth' => 'nullable|string',
            'r_address_line_1' => 'nullable|string',
            'r_address_line_2' => 'nullable|string',
            'r_country' => 'nullable|string',
            'r_city' => 'nullable|string',
            'r_postal_code' => 'nullable|string',
            'siren' => 'nullable|string',
            'website_url' => 'nullable|string|url',
        ];



        $messages = [

        ];

        // Validate the incoming request
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors()->toArray(), 422);
        }

        $dob = null;
        if(!empty($request->date_of_birth))
        {
            $dob = Carbon::createFromFormat('m/d/Y', $request->date_of_birth)->format('Y-m-d');
        }


        try{
            DB::beginTransaction();

            // save contact as a user
            $user = User::create([
                'salutation' => $request->salutation,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'company_name' => $request->company_name,
                'legal_status' => $request->legal_status,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'phone' => $request->phone,
                'date_of_birth' => $dob,
                'place_of_birth' => $request->place_of_birth,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'country' => $request->country,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'is_verified' => true,
            ]);

            // save data to contacts table
            $contact = Contact::create([
                'user_id' => $user->id,
                'created_by_id' => $authenticatedUser->id,
                'type' => $request->type,
                'category' => $request->category,
                'additional_info' => $request->additional_info,
            ]);

            // save bank details
            $bankDetails = BankDetail::create([
                'user_id' => $user->id,
                'name' => $request->bank_name,
                'rib_iban' => $request->rib_iban,
                'bic_swift' => $request->bic_swift,
                'address_line_1' => $request->bank_address_line_1,
                'address_line_2' => $request->bank_address_line_2,
                'country' => $request->bank_country,
                'city' => $request->bank_city,
                'postal_code' => $request->bank_postal_code,
            ]);

            // save entity representative data
            if(!empty($request->r_date_of_birth))
            {
                $dob = Carbon::createFromFormat('m/d/Y', $request->r_date_of_birth)->format('Y-m-d');
            }
            $representative = null;
            if($request->type === 'legal_entity')
            {
                $representative = EntityRepresentative::create([
                    'contact_id' => $contact->id,
                    'first_name' => $request->r_first_name,
                    'last_name' => $request->r_last_name,
                    'email' => $request->r_email,
                    'phone' => $request->r_phone,
                    'date_of_birth' => $dob,
                    'place_of_birth' => $request->r_place_of_birth,
                    'address_line_1' => $request->r_address_line_1,
                    'address_line_2' => $request->r_address_line_2,
                    'country' => $request->r_country,
                    'city' => $request->r_city,
                    'postal_code' => $request->r_postal_code,
                    'siren' => $request->siren,
                    'website_url' => $request->website_url,
                ]);
            }

            // assign contact to entity
            $entityContact = null;
            if($request->entity_id)
            {
                $entityContact = EntityContact::create([
                    'entity_id' => $request->entity_id,
                    'user_id' => $contact->id,
                ]);
            }
            DB::commit();
            // Prepare success response
            $success = [
                'user_id' => $user->id,
                'contact_id' => $contact->id,
                'bank_id' => $bankDetails->id,
                'representative_id' => $representative?->id,
            ];

            // Evaluate the message based on the $isNewUser condition
            $message = 'Contact saved successfully';
            return $this->sendResponse($success, $message);
        }catch (\Exception $e){
            DB::rollBack();
            return $this->sendError('Something went wrong', ['error' => $e->getMessage()], 500);
        }

    } // end store


    /*======= get all individual contact =========*/
    public function getIndividualContacts()
    {
        // Check if the user is authenticated via the 'api' guard
        if (!auth('api')->check()) {
            return $this->sendError('Please login first', [], 422);
        }

        $user = auth('api')->user();
        $individualContacts =
    }
}
