<?php

namespace App\Http\Controllers\API\Property;

use Exception;
use App\Models\Property;
use App\Trait\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;

class PropertyController extends Controller
{
    use ResponseTrait;
    public function createProperty(StorePropertyRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            // Create the main Property record
            $property = Property::create($data);

            // Create related records using relationships
            if ($request->has('unit_destination_premises')) {
                $property->unitDestinationPremises()->create($data['unit_destination_premises']);
            }

            if ($request->has('unit_other_facilities')) {
                $property->unitOtherFacilities()->create($data['unit_other_facilities']);
            }

            if ($request->has('bathroom_facilities')) {
                $property->bathroomFacilities()->create($data['bathroom_facilities']);
            }

            if ($request->has('unit_kitchen_facilities')) {
                $property->unitKitchenFacilities()->create($data['unit_kitchen_facilities']);
            }

            if ($request->has('unit_comfort_elements')) {
                $property->unitComfortElements()->create($data['unit_comfort_elements']);
            }

            if ($request->has('building_facilities')) {
                $property->buildingFacilities()->create($data['building_facilities']);
            }

            if ($request->has('unit_details')) {
                $property->unitDetails()->create($data['unit_details']);
            }

            DB::commit();

            // Load relationships for response
            $property->load([
                'unitDestinationPremises',
                'unitOtherFacilities',
                'bathroomFacilities',
                'unitKitchenFacilities',
                'unitComfortElements',
                'buildingFacilities',
                'unitDetails'
            ]);
            $message = 'Property created successfully.';
            return $this->sendResponse($property, $message);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return $this->sendError('Failed to create property due to database error', ['error' => $e->getMessage()], 500);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError('Failed to create property', ['error' => $e->getMessage()], 500);
        }
    }
}
