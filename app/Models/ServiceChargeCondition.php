<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceChargeCondition extends Model
{
    protected $fillable = [
        'lease_id',
        'type_of_charges',
        'monthly_flat_rate_amount',
        'fixed_charges_included',
        'monthly_provision_for_actual_charges',
        'types_of_actual_charges',
        'procedures_for_regularization_of_actual_charges',
        'distribution_of_charges_between_co_tenants',
        'property_tax_allocation',
        'co_ownership_charges_allocation',
        'insurance_allocation',
        'maintenance_repairs_allocation',
        'taxes_and_fees_allocation',
        'other_property_tax_allocation',
        'other_co_ownership_charges_allocation',
        'other_insurance_allocation',
        'other_maintenance_repairs_allocation',
        'other_taxes_and_fees_allocation',
        'security_deposit',
    ];

    protected $casts = [
        'monthly_flat_rate_amount' => 'decimal:2',
        'monthly_provision_for_actual_charges' => 'decimal:2',
        'security_deposit' => 'decimal:2',
    ];

    // Relationship with Lease model
    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}
