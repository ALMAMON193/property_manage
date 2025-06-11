<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_id',
        'property_type',
        'is_condominium',
        'name',
        'address',
        'post_code',
        'city',
        'country',
        'construction_year',
        'unit_type',
        'tax_number',
        'dpe',
        'dpe_validity',
        'floor',
        'lot_number',
        'cadastral_reference',
    ];

    protected $casts = [
        'address' => 'array',
        'property_type' => 'string',
        'is_condominium' => 'boolean',
        'dpe_validity' => 'date',
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function unitDestinationPremises()
    {
        return $this->hasOne(UnitDestinationPremises::class);
    }

    public function unitOtherFacilities()
    {
        return $this->hasOne(UnitOtherFacilities::class);
    }

    public function bathroomFacilities()
    {
        return $this->hasOne(BathroomFacilities::class);
    }

    public function unitComfortElements()
    {
        return $this->hasOne(UnitComfortElements::class);
    }

    public function buildingFacilities()
    {
        return $this->hasOne(BuldingFacilite::class);
    }
    public function unitKitchenFacilities()
    {
        return $this->hasOne(UnitkitchenFacilities::class);
    }
}
