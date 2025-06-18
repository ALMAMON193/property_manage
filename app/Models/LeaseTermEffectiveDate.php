<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaseTermEffectiveDate extends Model
{
    protected $fillable = [
        'lease_type',
        'furnished_lease_term_type',
        'furnished_lease_duration',
        'unfurnished_lease_term_type',
        'unfurnished_lease_duration',
        'commercial_lease_term_type',
        'commercial_lease_duration',
        'professional_lease_term_type',
        'professional_lease_duration',
        'lease_signing_date',
        'lease_effective_date',
        'lease_renewal_extension_conditions',
        'lease_removal_conditions',
    ];

    protected $casts = [
        'lease_signing_date' => 'date',
        'lease_effective_date' => 'date',
    ];
}
