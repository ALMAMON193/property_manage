<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_id', 'property_type', 'is_condominium', 'name', 'address',
        'post_code', 'city', 'country', 'construction_year', 'unit_type',
        'tax_number', 'dpe', 'dpe_validity', 'floor', 'lot_number',
        'cadastral_reference'
    ];

    protected $casts = [
        'address' => 'array',
        'is_condominium' => 'boolean',
        'dpe_validity' => 'date',
    ];

    // Relationships
    public function unitDestinationPremises()
    {
        return $this->hasOne(UnitDestinationPremise::class);
    }

    public function unitOtherFacilities()
    {
        return $this->hasOne(UnitOtherFacility::class);
    }

    public function bathroomFacilities()
    {
        return $this->hasOne(UnitBathroomFacility::class);
    }

    public function unitKitchenFacilities()
    {
        return $this->hasOne(UnitKitchenFacility::class);
    }

    public function unitComfortElements()
    {
        return $this->hasOne(UnitComfortElement::class);
    }

    public function buildingFacilities()
    {
        return $this->hasOne(BuildingFacility::class);
    }

    public function unitDetails()
    {
        return $this->hasOne(UnitDetail::class);
    }

    public function parent()
    {
        return $this->belongsTo(Property::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Property::class, 'parent_id');
    }
}
