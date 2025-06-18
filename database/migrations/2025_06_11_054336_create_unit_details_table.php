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
        Schema::create('unit_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->integer('num_of_living_room');
            $table->integer('num_of_bedroom');
            $table->integer('num_of_bathroom');
            $table->integer('num_of_toilet');
            $table->string('habitable_area');
            $table->string('commercial_area');
            $table->string('sales_area');
            $table->bigInteger('storage_area');
            $table->string('office_space');
            $table->string('reserve_area');
            $table->string('sanitary_area');
            $table->string('professional_surface');
            $table->string('reception_area');
            $table->string('waiting_room_area');
            $table->string('consultation_area');
            $table->string('parking_type');
            $table->string('parking_lease_length');
            $table->string('parking_lease_width');
            $table->string('parking_lease_height');
            $table->string('property_type');
            $table->string('other_type_of_lot');
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_details');
    }
};
