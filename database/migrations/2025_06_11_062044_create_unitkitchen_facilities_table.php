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
        Schema::create('unitkitchen_facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->enum('cuisine_type', ['Equipped', 'Furnished', 'Kitchenette', 'Not Equipped', 'Kitchen Area'])->nullable();
            $table->boolean('cooking_plates')->default(false);
            $table->enum('cooking_plate_type', ['electric', 'gas', 'induction'])->nullable();
            $table->bigInteger('number_of_burners')->nullable();
            $table->boolean('oven')->default(false);
            $table->enum('oven_type', ['electric', 'gas', 'microwave'])->nullable();
            $table->boolean('fridge')->default(false);
            $table->enum('refrigerator_type', ['single', 'double', 'side-by-side'])->nullable();
            $table->string('refrigerator_capacity')->nullable();
            $table->boolean('freezer')->default(false);
            $table->boolean('extractor_hood')->default(false);
            $table->boolean('microwave')->default(false);
            $table->boolean('dishwasher')->default(false);
            $table->bigInteger('washing_machine')->nullable();
            $table->timestamps();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unitkitchen_facilities');
    }
};
