<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('building_facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id');

            // Common facilities
            $table->string('entrance_hall');
            $table->string('stairs');
            $table->string('corridors');
            $table->boolean('caretaker')->default(false);
            $table->boolean('elevator')->default(false);
            $table->string('elevator_access_condition')->nullable();
            $table->boolean('bicycle_storage')->default(false);
            $table->boolean('common_courtyard')->default(false);
            $table->boolean('common_garden')->default(false);
            $table->boolean('garbage_room')->default(false);
            $table->string('other_common_areas')->nullable();

            // Collective Equipment (including previously missing ones)
            $table->boolean('intercom')->default(false);
            $table->boolean('digital_lock')->default(false);
            $table->boolean('collective_tv_antenna')->default(false);
            $table->boolean('childrens_playground')->default(false);
            $table->boolean('collective_green_spaces')->default(false);
            $table->boolean('parking')->default(false);
            $table->boolean('automated_access_gate')->default(false);
            $table->string('automated_access_gate_type')->nullable();
            $table->boolean('collective_outdoor_lighting')->default(false);
            $table->boolean('cellar')->default(false);
            $table->boolean('collective_alarm')->default(false);
            $table->boolean('electrical_charging_station_vehicle')->default(false);
            $table->boolean('common_tennis_court')->default(false);
            $table->boolean('collective_heating_with_individual_meter')->default(false);
            $table->boolean('collective_heating_without_individual_meter')->default(false);
            $table->boolean('condominium_regulations')->default(false);
            $table->boolean('video_surveillance_cameras')->default(false);
            $table->boolean('smoke_detection_system')->default(false);
            $table->boolean('collective_ventilation_system')->default(false);
            $table->boolean('collective_access_lighting')->default(false);
            $table->boolean('common_sanitary_facilities')->default(false);
            $table->boolean('fire_safety_system')->default(false);
            $table->boolean('service_elevator')->default(false);
            $table->boolean('common_swimming_pool')->default(false);
            $table->boolean('collective_heating')->default(false);
            $table->boolean('collective_hot_water')->default(false);
            $table->boolean('collective_hot_water_with_individual_meter')->default(false);
            $table->boolean('collective_hot_water_without_individual_meter')->default(false);
            $table->boolean('other_specific_collective_equipment')->default(false);

            $table->timestamps();

            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulding_facilites');
    }
};
