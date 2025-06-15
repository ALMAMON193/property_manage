<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->unsignedBigInteger('building_id')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->text('address')->nullable();
            $table->string('post_code', 10)->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('tax_number', 20)->nullable();
            $table->string('dpe')->nullable();
            $table->date('dpe_validity')->nullable();
            $table->year('construction_year')->nullable();
            $table->integer('floor')->nullable();
            $table->string('lot_number')->nullable();
            $table->text('cadastral_reference')->nullable();
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
