<?php

namespace App\Http\Controllers\API\Property;

use Exception;
use App\Models\Lease;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeaseStoreRequest;

class LeaseApiController extends Controller
{
    use ResponseTrait;
    public function createLease(LeaseStoreRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            // Create main lease record
            $lease = Lease::create([
                'tenant_id' => $data['tenant_id'] ?? null,
                'property_id' => $data['property_id'] ?? null,
                'guarantor' => $data['guarantor']
            ]);

            // Create lease end details if provided
            if (isset($data['lease_end_details']) && !empty(array_filter($data['lease_end_details']))) {
                $lease->leaseEndDetails()->create($data['lease_end_details']);
            }

            // Create rent automation settings if provided
            if (isset($data['rent_automation_settings']) && !empty(array_filter($data['rent_automation_settings']))) {
                $lease->rentAutomationSettings()->create($data['rent_automation_settings']);
            }

            // Create lease documents if provided
            if (isset($data['lease_documents']) && !empty(array_filter($data['lease_documents']))) {
                $lease->leaseDocuments()->create($data['lease_documents']);
            }

            // Create specific clauses if provided
            if (isset($data['lease_specific_clauses']) && !empty(array_filter($data['lease_specific_clauses']))) {
                $lease->leaseSpecificClauses()->create($data['lease_specific_clauses']);
            }

            // Create rent revision conditions if provided
            if (isset($data['rent_revision_conditions']) && !empty(array_filter($data['rent_revision_conditions']))) {
                $lease->rentRevisionConditions()->create($data['rent_revision_conditions']);
            }

            // Create service charge conditions if provided
            if (isset($data['service_charge_conditions']) && !empty(array_filter($data['service_charge_conditions']))) {
                $lease->serviceChargeConditions()->create($data['service_charge_conditions']);
            }

            // Create financial conditions if provided
            if (isset($data['lease_financial_conditions']) && !empty(array_filter($data['lease_financial_conditions']))) {
                $lease->leaseFinancialConditions()->create($data['lease_financial_conditions']);
            }

            // Create term effective dates if provided
            if (isset($data['lease_term_effective_dates']) && !empty(array_filter($data['lease_term_effective_dates']))) {
                $lease->leaseTermEffectiveDates()->create($data['lease_term_effective_dates']);
            }

            DB::commit();

            // Load all relationships for response
            $lease->load([
                'leaseEndDetails',
                'rentAutomationSettings',
                'leaseDocuments',
                'leaseSpecificClauses',
                'rentRevisionConditions',
                'serviceChargeConditions',
                'leaseFinancialConditions',
                'leaseTermEffectiveDates'
            ]);
            $message = 'Lease created successfully.';
            return $this->sendResponse($lease, $message);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return $this->sendError(' Database error while creating lease', ['error' => $e->getMessage()], 500);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError('Failed to create lease', ['error' => $e->getMessage()], 500);
        }
    }
}
