<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitkitchenFacilities extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'kitchen_type',
        'cooking_plates',
        'cooking_plate_type',
        'number_of_burners',
        'oven',
        'oven_type',
        'fridge',
        'refrigerator_type',
        'refrigerator_capacity',
        'freezer',
        'extractor_hood',
        'microwave',
        'dishwasher',
        'washing_machine',
        'dryer',
        'small_household_appliances',
        'small_household_appliances_details',
        'high_cupboard',
        'low_cupboard',
        'work_plan',
        'sink',
        'num_of_basins',
        'sink_material',
        'kithcen_light'
    ];

    protected $casts = [
        'cooking_plates' => 'boolean',
        'oven' => 'boolean',
        'fridge' => 'boolean',
        'freezer' => 'boolean',
        'extractor_hood' => 'boolean',
        'microwave' => 'boolean',
        'dishwasher' => 'boolean',
        'dryer' => 'boolean',
        'small_household_appliances' => 'boolean',
        'high_cupboard' => 'boolean',
        'low_cupboard' => 'boolean',
        'work_plan' => 'boolean',
        'sink' => 'boolean',
        'num_of_basins' => 'boolean',
        'kithcen_light' => 'boolean'
    ];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
