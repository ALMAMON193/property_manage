<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuildingFacility extends Model
{
    protected $table = 'building_facilities';

    protected $fillable = [
        'building_id',
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
        'intercom',
        'digital_lock',
        'collective_tv_antenna',
        'childrens_playground',
        'collective_green_spaces',
        'parking',
        'automated_access_gate',
        'automated_access_gate_type',
        'collective_outdoor_lighting',
        'cellar',
        'collective_alarm',
        'electrical_charging_station_vehicle',
        'common_tennis_court',
        'collective_heating_with_individual_meter',
        'collective_heating_without_individual_meter',
        'condominium_regulations',
        'video_surveillance_cameras',
        'smoke_detection_system',
        'collective_ventilation_system',
        'collective_access_lighting',
        'common_sanitary_facilities',
        'fire_safety_system',
        'service_elevator',
        'common_swimming_pool',
        'collective_heating',
        'collective_hot_water',
        'collective_hot_water_with_individual_meter',
        'collective_hot_water_without_individual_meter',
        'other_specific_collective_equipment',
    ];

    protected $casts = [
        'caretaker' => 'boolean',
        'elevator' => 'boolean',
        'bicycle_storage' => 'boolean',
        'common_courtyard' => 'boolean',
        'common_garden' => 'boolean',
        'garbage_room' => 'boolean',
        'intercom' => 'boolean',
        'digital_lock' => 'boolean',
        'collective_tv_antenna' => 'boolean',
        'childrens_playground' => 'boolean',
        'collective_green_spaces' => 'boolean',
        'parking' => 'boolean',
        'automated_access_gate' => 'boolean',
        'collective_outdoor_lighting' => 'boolean',
        'cellar' => 'boolean',
        'collective_alarm' => 'boolean',
        'electrical_charging_station_vehicle' => 'boolean',
        'common_tennis_court' => 'boolean',
        'collective_heating_with_individual_meter' => 'boolean',
        'collective_heating_without_individual_meter' => 'boolean',
        'condominium_regulations' => 'boolean',
        'video_surveillance_cameras' => 'boolean',
        'smoke_detection_system' => 'boolean',
        'collective_ventilation_system' => 'boolean',
        'collective_access_lighting' => 'boolean',
        'common_sanitary_facilities' => 'boolean',
        'fire_safety_system' => 'boolean',
        'service_elevator' => 'boolean',
        'common_swimming_pool' => 'boolean',
        'collective_heating' => 'boolean',
        'collective_hot_water' => 'boolean',
        'collective_hot_water_with_individual_meter' => 'boolean',
        'collective_hot_water_without_individual_meter' => 'boolean',
        'other_specific_collective_equipment' => 'boolean',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
}
