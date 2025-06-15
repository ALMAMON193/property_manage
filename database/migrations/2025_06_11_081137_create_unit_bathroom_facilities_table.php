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
        Schema::create('unit_bathroom_facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->boolean('shower')->default(false);
            $table->string('shower_type')->nullable();
            $table->boolean('bathtub')->default(false);
            $table->string('bathtub_type')->nullable();
            $table->boolean('washbasin')->default(false);
            $table->string('washbasin_type')->nullable();
            $table->boolean('wc')->default(false);
            $table->string('wc_type')->nullable();
            $table->boolean('towel_dryers')->default(false);
            $table->boolean('mirror')->default(false);
            $table->boolean('bathroom_lighting')->default(false);
            $table->boolean('washbasin_furniture')->default(false);
            $table->boolean('cupboards')->default(false);
            $table->timestamps();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
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
