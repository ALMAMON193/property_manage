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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->enum('property_type', ['building', 'unit'])->nullable();
            $table->boolean('is_condominium')->nullable();
            $table->string('name')->nullable();
            $table->json('address')->nullable();
            $table->string('post_code', 10)->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->year('construction_year')->nullable();
            $table->string('unit_type')->nullable();
            $table->string('tax_number', 20)->nullable();
            $table->string('dpe')->nullable();
            $table->date('dpe_validity')->nullable();
            $table->integer('floor')->nullable();
            $table->string('lot_number')->nullable();
            $table->text('cadastral_reference')->nullable();
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
