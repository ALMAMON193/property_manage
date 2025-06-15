<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\Contact;
use App\Models\EntityAccess;
use App\Models\EntityRepresentative;
use App\Models\Property;
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
            'salutation' => 'required_if:type,individual|string',
            'first_name' => 'required_if:type,individual|string',
            'last_name' => 'required_if:type,individual|string',
            'email' => 'required|email',
            'phone' => 'required|string|regex:/^\+?[0-9]\d{1,14}$/',
            'date_of_birth' => 'nullable|date_format:Y-m-d',
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
            'legal_status' => 'required_if:type,legal_entity|string',
            'company_name' => 'required_if:type,legal_entity|string',

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
            'r_date_of_birth' => 'nullable|date|date_format:Y-m-d',
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
            $dob = $request->date_of_birth;
        }



        try{
            DB::beginTransaction();

            // save contact as a user
            $user = User::create([
                // For individual
                'salutation'    => $request->type === 'individual' ? $request->salutation : null,
                'first_name'    => $request->type === 'individual' ? $request->first_name : null,
                'last_name'     => $request->type === 'individual' ? $request->last_name : null,

                // For legal entity
                'company_name'  => $request->type === 'legal_entity' ? $request->company_name : null,
                'legal_status'  => $request->type === 'legal_entity' ? $request->legal_status : null,

                //common for both
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
                $dob = $request->r_date_of_birth;
            }
            $representative = null;
            if($request->type === 'legal_entity')
            {
                $representative = EntityRepresentative::create([
                    'contact_id' => $contact->id,
                    'salutation' => $request->r_salutation,
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
            $entityAccess = null;
            if($request->entity_id)
            {
                $entityAccess = EntityAccess::create([
                    'entity_id' => $request->entity_id,
                    'user_id' => $user->id,
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

        // Fetch contacts of type 'individual' created by the authenticated user
        $contacts = Contact::with(['user:id,first_name,last_name']) // eager load only required fields
        ->where('created_by_id', $user->id)
            ->where('type', 'individual')
            ->get()
            ->map(function ($contact) {
                return [
                    'id' => $contact->user->id,
                    'name' => $contact->user->first_name . ' ' . $contact->user->last_name,
                ];
            });

        return $this->sendResponse($contacts, 'Individual contacts retrieved successfully');
    }


    /*======= get all legal entity contact =========*/
    public function getLegalEntityContacts()
    {
        // Check if the user is authenticated via the 'api' guard
        if (!auth('api')->check()) {
            return $this->sendError('Please login first', [], 422);
        }

        $user = auth('api')->user();

        // Fetch contacts of type 'individual' created by the authenticated user
        $contacts = Contact::with(['user:id,company_name']) // eager load only required fields
        ->where('created_by_id', $user->id)
            ->where('type', 'legal_entity')
            ->get()
            ->map(function ($contact) {
                return [
                    'id' => $contact->user->id,
                    'name' => $contact->user->company_name,
                ];
            });

        return $this->sendResponse($contacts, 'Legal entity contacts retrieved successfully');
    }


    /*======= get all contacts =========*/
    /*public function getAllContacts()
    {
        // Check if the user is authenticated via the 'api' guard
        if (!auth('api')->check()) {
            return $this->sendError('Please login first', [], 422);
        }

        $user = auth('api')->user();

        // Get all contacts created by the authenticated user and eager load relationships
        $contacts = $user->contactsCreated()
            ->with([
                'user.bankDetail',   // contact's assigned user and their bank detail
                'representative'     // contact's representative
            ])
            ->get();

        return $this->sendResponse($contacts, 'All contacts retrieved successfully');
    }*/

    public function getAllContacts()
    {
        // Ensure the user is authenticated
        if (!auth('api')->check()) {
            return $this->sendError('Please login first', [], 422);
        }

        $user = auth('api')->user();

        // Get all entity IDs created by this user
        $ownedEntityIds = $user->entities()->pluck('id');

        // Get all contacts created by this user
        $contacts = $user->contactsCreated()
            ->with([
                'user.bankDetail',
                'representative',
                // Load entities where this contact's user is assigned
                'user.entityAccesses.entity' => function ($query) use ($ownedEntityIds) {
                    $query->whereIn('id', $ownedEntityIds);
                }
            ])
            ->get();

        return $this->sendResponse($contacts, 'All contacts retrieved successfully');
    }


}
