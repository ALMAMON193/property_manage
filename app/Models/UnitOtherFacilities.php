<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitOtherFacilities extends Model
{
     use HasFactory;

    protected $fillable = [
        'property_id',
        'individual_heating',
        'individual_heating_type',
        'individual_heating_radiators',
        'individual_heating_radiators_type',
        'number_of_radiators',
        'collective_heating',
        'collective_heating_without_individual_meter',
        'collective_heating_with_individual_meter',
        'individual_hot_water',
        'individual_hot_water_type',
        'collective_hot_water',
        'collective_hot_water_without_individual_meter',
        'collective_hot_water_with_individual_meter',
        'vmc_ventilation',
        'vmc_type',
        'telephone_connection',
        'telephone_connection_active_line',
        'fiber_internet_connection',
        'television_connection_antenna_type',
        'television_connection_number_of_tv_sockets',
        'individual_water_meter_meter_number',
        'individual_electricity_meter_meter_number',
        'individual_gas_meter_meter_number',
    ];

    protected $casts = [
        'individual_heating' => 'boolean',
        'individual_heating_radiators' => 'boolean',
        'collective_heating' => 'boolean',
        'collective_heating_without_individual_meter' => 'boolean',
        'collective_heating_with_individual_meter' => 'boolean',
        'individual_hot_water' => 'boolean',
        'collective_hot_water' => 'boolean',
        'collective_hot_water_without_individual_meter' => 'boolean',
        'collective_hot_water_with_individual_meter' => 'boolean',
        'vmc_ventilation' => 'boolean',
        'telephone_connection' => 'boolean',
        'telephone_connection_active_line' => 'boolean',
        'fiber_internet_connection' => 'boolean',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
