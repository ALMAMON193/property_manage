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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('retailer_id');
            $table->string('title')->nullable();
            $table->string('brand')->nullable();
            $table->string('caliber')->nullable();
            $table->string('limit')->nullable();
            $table->float('price')->nullable();
            $table->string('url')->nullable();
            $table->string('quantity')->nullable();
            $table->string('grains')->nullable();
            $table->integer('num_of_rounds')->nullable();
            $table->float('cost_per_round')->nullable();
            $table->string('condition')->nullable();
            $table->string('casing')->nullable();
            $table->boolean('sponsored')->default(false);
            $table->timestamps();

            $table->foreign('retailer_id')->references('id')->on('retailers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
