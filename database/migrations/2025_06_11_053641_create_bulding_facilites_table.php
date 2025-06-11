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
        Schema::create('bulding_facilites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
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
            $table->longText('collective_equipment')->nullable();
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
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
