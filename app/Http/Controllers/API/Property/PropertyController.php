<?php

namespace App\Http\Controllers\API\Property;

use Exception;
use App\Models\Property;
use App\Models\UnitDetails;
use App\Trait\ResponseTrait;
use App\Models\BuldingFacilite;
use App\Models\BathroomFacilities;
use Illuminate\Support\Facades\DB;
use App\Models\UnitComfortElements;
use App\Models\UnitOtherFacilities;
use App\Http\Controllers\Controller;
use App\Models\UnitkitchenFacilities;
use App\Models\UnitDestinationPremises;
use App\Http\Requests\StorePropertyRequest;

class PropertyController extends Controller
{
    use ResponseTrait;
    public function createProperty(StorePropertyRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $property = Property::create($data);

            if ($request->has('unit_destination_premises')) {
                $unitDestinationData = $request->input('unit_destination_premises');
                $unitDestinationData['property_id'] = $property->id;
                UnitDestinationPremises::create($unitDestinationData);
            }

            if ($request->has('unit_other_facilities')) {
                $unitOtherFacilitiesData = $request->input('unit_other_facilities');
                $unitOtherFacilitiesData['property_id'] = $property->id;
                UnitOtherFacilities::create($unitOtherFacilitiesData);
            }

            if ($request->has('bathroom_facilities')) {
                $bathroomFacilitiesData = $request->input('bathroom_facilities');
                $bathroomFacilitiesData['property_id'] = $property->id;
                BathroomFacilities::create($bathroomFacilitiesData);
            }

            if ($request->has('unit_kitchen_facilities')) {
                $unitKitchenFacilitiesData = $request->input('unit_kitchen_facilities');
                $unitKitchenFacilitiesData['property_id'] = $property->id;
                UnitkitchenFacilities::create($unitKitchenFacilitiesData);
            }

            if ($request->has('unit_comfort_elements')) {
                $unitComfortElementsData = $request->input('unit_comfort_elements');
                $unitComfortElementsData['property_id'] = $property->id;
                UnitComfortElements::create($unitComfortElementsData);
            }

            if ($request->has('building_facilities')) {
                $buildingFacilitiesData = $request->input('building_facilities');
                $buildingFacilitiesData['property_id'] = $property->id;
                BuldingFacilite::create($buildingFacilitiesData);
            }

            if ($request->has('unit_details')) {
                $unitDetailsData = $request->input('unit_details');
                $unitDetailsData['property_id'] = $property->id;
                UnitDetails::create($unitDetailsData);
            }

            DB::commit();
            return $this->sendResponse('Property created successfully', $property, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError('Failed to create property', ['error' => $e->getMessage()], 500);
        }
    }

}

