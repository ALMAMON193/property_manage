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
        Schema::create('unit_destination_premises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->text('auth_com_act')->nullable(); // Shortened: authorized_commercial_activities
            $table->text('proh_com_act')->nullable(); // Shortened: prohibited_commercial_activities
            $table->boolean('excl_clause')->default(false); // Shortened: exclusivity_clause
            $table->text('auth_lib_prof')->nullable(); // Shortened: authorized_liberal_professions
            $table->text('proh_lib_prof')->nullable(); // Shortened: prohibited_liberal_professions
            $table->boolean('excl_clause_prof')->default(false); // Shortened: exclusivity_clause_professions
            $table->text('auth_rel_act')->nullable(); // Shortened: authorized_related_activities
            $table->text('excl_veh_park_type')->nullable(); // Shortened: exclusive_use_vehicle_parking_lease_authorized_vehicle_type
            $table->boolean('proh_store')->default(false); // Shortened: prohibition_on_storage_of_goods_personal_items_parking_lease
            $table->text('spec_use_lot')->nullable(); // Shortened: specific_use_of_the_lot_other_type_of_lot
            $table->text('spec_proh_lot')->nullable(); // Shortened: specific_prohibitions_use_other_type_of_lot
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_destination_premises');
    }
};
