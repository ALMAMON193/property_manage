<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuldingFacilite extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'entrance_hall',
        'stairs',
        'corridors',
        'caretaker',
        'elevator',
        'elevator_access_condition',
        'bicycle_storage',
        'common_courtyard',
        'common_garden',
        'garbage_room',
        'other_common_areas',
        'collective_equipment',
    ];

    protected $casts = [
        'caretaker' => 'boolean',
        'elevator' => 'boolean',
        'bicycle_storage' => 'boolean',
        'common_courtyard' => 'boolean',
        'common_garden' => 'boolean',
        'garbage_room' => 'boolean',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
