<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\EntityAccess;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


    /*====== get the entities which has granted access*/
    public function getAccessibleEntities()
    {
        // Ensure the user is authenticated via 'api' guard
        if (!auth('api')->check()) {
            return $this->sendError('Please login first', [], 422);
        }

        $user = auth('api')->user();

        // Get all entities the user has access to (via entity_accesses pivot table)
        $entities = $user->accessibleEntities()->latest()->get();

        return $this->sendResponse($entities, 'Accessible entities retrieved successfully.');
    }


    public function storeEntity(Request $request)
    {
        if (!auth('api')->check()) {
            return $this->sendError('Please login first', [], 422);
        }

        $user = auth('api')->user();

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'type' => 'required|in:individual,joint_owner,legal_entity',
            'contact_user_id' => 'nullable',
            'contact_user_id.*' => 'exists:users,id',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors()->toArray(), 422);
        }

        DB::beginTransaction();

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

            // Normalize single or multiple contact_user_id into an array
            $contactUserIds = $request->contact_user_id;

            // Sync entity accesses
            if (!empty($contactUserIds)) {
                EntityAccess::where('entity_id', $entity->id)->delete();

                foreach ($contactUserIds as $userId) {
                    EntityAccess::create([
                        'entity_id' => $entity->id,
                        'user_id' => $userId,
                    ]);
                }
            }

            DB::commit();

            return $this->sendResponse($entity, 'Entity saved successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Something went wrong.', ['error' => $e->getMessage()], 500);
        }
    }


}
