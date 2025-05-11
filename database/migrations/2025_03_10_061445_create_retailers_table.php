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
        Schema::create('retailers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('retailer_website');
            $table->string('data_url')->unique();
            $table->string('update_interval')->comment('1/2/3/live/never minute');
            $table->enum('type', ['xml', 'json', 'text']); //content type in the url
            $table->enum('status', ['active', 'in_active'])->default('active');
            $table->timestamps();
        });
    }

    /**
     *
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retailers');
    }
};
