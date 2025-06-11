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
        Schema::create('bathroom_facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->boolean('shower')->default(false);
            $table->enum('shower_type', ['standard', 'rain', 'handheld'])->nullable();
            $table->boolean('bathtub')->default(false);
            $table->enum('bathtub_type', ['standard', 'jacuzzi', 'corner'])->nullable();
            $table->boolean('washbasin')->default(false);
            $table->enum('washbasin_type', ['single', 'double', 'pedestal'])->nullable();
            $table->boolean('wc')->default(false);
            $table->enum('wc_type', ['standard', 'bidet', 'wall-hung'])->nullable();
            $table->boolean('towel_dryers')->default(false);
            $table->boolean('mirror')->default(false);
            $table->boolean('bathroom_lighting')->default(false);
            $table->boolean('washbasin_furniture')->default(false);
            $table->boolean('cupboards')->default(false);
            $table->boolean('dryer')->default(false);
            $table->timestamps();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bathroom_facilities');
    }
};
