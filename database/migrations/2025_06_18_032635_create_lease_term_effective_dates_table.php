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
        Schema::create('lease_term_effective_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lease_id');
           // Lease Type Field
            $table->string('lease_type')->nullable();
            // Lease Term Type and Duration (Furnished Lease)
            $table->string('furnished_lease_term_type')->nullable();
            $table->integer('furnished_lease_duration')->nullable();

            // Lease Term Type and Duration (Unfurnished Lease)
            $table->string('unfurnished_lease_term_type')->nullable();
            $table->integer('unfurnished_lease_duration')->nullable();

            // Lease Term Type and Duration (Commercial Lease)
            $table->string('commercial_lease_term_type')->nullable();
            $table->integer('commercial_lease_duration')->nullable();

            // Lease Term Type and Duration (Professional Lease)
            $table->string('professional_lease_term_type')->nullable();
            $table->integer('professional_lease_duration')->nullable();

            // Dates
            $table->date('lease_signing_date')->nullable();
            $table->date('lease_effective_date')->nullable();

            // Conditions
            $table->text('lease_renewal_extension_conditions')->nullable();
            $table->text('lease_removal_conditions')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lease_term_effective_dates');
    }
};
