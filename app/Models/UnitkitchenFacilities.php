<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitkitchenFacilities extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'cuisine_type',
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
    ];

    protected $casts = [
        'cooking_plates' => 'boolean',
        'oven' => 'boolean',
        'fridge' => 'boolean',
        'freezer' => 'boolean',
        'extractor_hood' => 'boolean',
        'microwave' => 'boolean',
        'dishwasher' => 'boolean',
    ];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
