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
        Schema::create('unit_other_facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->boolean('individual_heating')->default(false);
            $table->string('individual_heating_type')->nullable();
            $table->boolean('individual_heating_radiators')->default(false);
            $table->string('individual_heating_radiators_type')->nullable();
            $table->integer('number_of_radiators')->nullable();
            $table->boolean('collective_heating')->default(false);
            $table->boolean('collective_heating_without_individual_meter')->default(false);
            $table->boolean('collective_heating_with_individual_meter')->default(false);
            $table->boolean('individual_hot_water')->default(false);
            $table->string('individual_hot_water_type')->nullable();
            $table->boolean('collective_hot_water')->default(false);
            $table->boolean('collective_hot_water_without_individual_meter')->default(false);
            $table->boolean('collective_hot_water_with_individual_meter')->default(false);
            $table->boolean('vmc_ventilation')->default(false);
            $table->string('vmc_type')->nullable();
            $table->boolean('telephone_connection')->default(false);
            $table->boolean('telephone_connection_active_line')->default(false);
            $table->boolean('fiber_internet_connection')->default(false);
            $table->string('television_connection_antenna_type')->nullable();
            $table->integer('television_connection_number_of_tv_sockets')->nullable();
            $table->boolean('individual_water_meter')->default(false);
            $table->string('individual_water_meter_meter_number')->nullable();
            $table->boolean('individual_electricity_meter')->default(false);
            $table->string('individual_electricity_meter_number')->nullable();
            $table->boolean('individual_gas_meter')->default(false);
            $table->string('individual_gas_meter_number')->nullable();
            $table->timestamps();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_other_facilities');
    }
};
