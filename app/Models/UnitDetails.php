<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'num_of_living_room',
        'num_of_bedroom',
        'num_of_bathroom',
        'num_of_toilet',
        'habitable_area',
        'commercial_area',
        'sales_area',
        'storage_area',
        'office_space',
        'reserve_area',
        'sanitary_area',
        'professional_surface',
        'reception_area',
        'waiting_room_area',
        'consultation_area',
        'parking_type',
        'parking_lease_length',
        'parking_lease_width',
        'parking_lease_height',
        'property_type',
        'other_type_of_lot',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
