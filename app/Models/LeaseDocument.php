<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaseDocument extends Model
{
    protected $fillable = [
        'lease_id',
        'inventory_of_premises_annex',
        'inventory_of_furnishings_annex',
        'furniture_inventory_annex',
        'co_ownership_regulations_annex',
        'student_mobility_lease_justification_annex',
        'specific_lease_justification_annex',
        'technical_diagnostics_ddt_annex',
        'landlords_bank_details_annex',
        'other_lease_related_documents',
    ];

    // Relationship with Lease model
    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}
