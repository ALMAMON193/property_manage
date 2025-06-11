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
        Schema::create('unit_comfort_elements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->boolean('balcony')->default(false);
            $table->string('balcony_surface')->nullable();
            $table->string('balcony_exposure')->nullable();
            $table->boolean('terrace')->default(false);
            $table->string('terrace_surface')->nullable();
            $table->string('terrace_exposure')->nullable();
            $table->enum('terrace_type', ['open', 'covered', 'semi-covered'])->nullable();
            $table->boolean('private_garden')->default(false);
            $table->string('private_garden_area')->nullable();
            $table->string('private_garden_description')->nullable();
            $table->boolean('private_celller')->default(false);
            $table->boolean('private_parking')->default(false);
            $table->string('private_parking_location')->nullable();
            $table->string('private_parking_level')->nullable();
            $table->boolean('private_garage')->default(false);
            $table->string('private_garage_location')->nullable();
            $table->string('private_garage_level')->nullable();
            $table->string('other_elements')->nullable();
            $table->boolean('air_conditioning')->default(false);
            $table->enum('air_conditioning_type', ['split', 'central', 'portable'])->nullable();
            $table->enum('air_condition_mode', ['cool', 'heat', 'auto'])->nullable();
            $table->boolean('alarm')->default(false);
            $table->string('alarm_type')->nullable();
            $table->string('alarm_remote_monitoring')->nullable();
            $table->boolean('metal_curtains')->default(false);
            $table->boolean('secure_showcase')->default(false);
            $table->boolean('smoke_extraction')->default(false);
            $table->boolean('pmr_access')->default(false);
            $table->string('pmr_access_details')->nullable();
            $table->string('other_specific_equipment')->nullable();
            $table->string('specific_access_condition')->nullable();
            $table->string('specific_use_condition')->nullable();
            $table->timestamps();
             $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_comfort_elements');
    }
};
