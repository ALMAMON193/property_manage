<?php

namespace App\Http\Controllers\API\Property;

use Exception;
use App\Models\Tenant;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TenantApiController extends Controller
{
    use ResponseTrait;
    public function createTenant(Request $request)
    {
        $validatedData = $request->validate([
            'lease_id' => 'nullable',
            'type' => 'required|in:individual,legal_entity',
            'category' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string|max:1000',
        ]);

        try {
            // Store tenant
            $tenant = Tenant::create($validatedData);
            $message = 'Tenant created successfully';

            return $this->sendResponse($tenant, $message);
        } catch (Exception $e) {
            $message = 'Failed to create tenant: ' . $e->getMessage();
            return $this->sendError($message, [], 500);
        }
    }
}
