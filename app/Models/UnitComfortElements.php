<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitComfortElements extends Model
{
     use HasFactory;

    protected $fillable = [
        'property_id',
        'balcony',
        'balcony_surface',
        'balcony_exposure',
        'terrace',
        'terrace_surface',
        'terrace_exposure',
        'terrace_type',
        'private_garden',
        'private_garden_area',
        'private_garden_description',
        'private_celller',
        'private_parking',
        'private_parking_location',
        'private_parking_level',
        'private_garage',
        'private_garage_location',
        'private_garage_level',
        'other_elements',
        'air_conditioning',
        'air_conditioning_type',
        'air_condition_mode',
        'alarm',
        'alarm_type',
        'alarm_remote_monitoring',
        'metal_curtains',
        'secure_showcase',
        'smoke_extraction',
        'pmr_access',
        'pmr_access_details',
        'other_specific_equipment',
        'specific_access_condition',
        'specific_use_condition',
    ];

    protected $casts = [
        'balcony' => 'boolean',
        'terrace' => 'boolean',
        'private_garden' => 'boolean',
        'private_celller' => 'boolean',
        'private_parking' => 'boolean',
        'private_garage' => 'boolean',
        'air_conditioning' => 'boolean',
        'alarm' => 'boolean',
        'metal_curtains' => 'boolean',
        'secure_showcase' => 'boolean',
        'smoke_extraction' => 'boolean',
        'pmr_access' => 'boolean',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
