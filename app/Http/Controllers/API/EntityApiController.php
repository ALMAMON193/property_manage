<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\EntityContact;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntityApiController extends Controller
{
    use ResponseTrait;

    public function getAllEntities()
    {
        // Check if the user is authenticated via the 'api' guard
        if (!auth('api')->check()) {
            return $this->sendError('Please login first', [], 422);
        }

        $user = auth('api')->user();
        $entities = Entity::where('user_id', $user->id)->latest()->get();

        $message = 'Entity retrieved successfully.';
        return $this->sendResponse($entities, $message);

    }
    public function storeEntity(Request $request)
    {
        // Check if the user is authenticated via the 'api' guard
        if (!auth('api')->check()) {
            return $this->sendError('Please login first', [], 422);
        }

        $user = auth('api')->user();

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'type' => 'required|in:individual,joint_owner,legal_entity',
            'contact_ids' => 'nullable|array',
            'contact_ids.*' => 'exists:contacts,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors()->toArray(), 422);
        }

        try {
            // Create or update entity for this user
            $entity = Entity::updateOrCreate(
                [
                    'name' => $request->name,
                    'user_id' => $user->id,
                ],
                [
                    'type' => $request->type,
                ]
            );

            // Attach contacts to the entity
            if (!empty($request->contact_ids)) {
                foreach ($request->contact_ids as $contactId) {
                    EntityContact::create([
                        'entity_id' => $entity->id,
                        'user_id' => $contactId,
                    ]);
                }
            }

            return $this->sendResponse($entity, 'Entity saved successfully.');

        } catch (\Exception $e) {
            return $this->sendError('Something went wrong.', ['error' => $e->getMessage()], 500);
        }
    }

}
