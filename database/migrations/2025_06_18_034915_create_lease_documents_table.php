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
        Schema::create('lease_documents', function (Blueprint $table) {
            $table->id();
            // Foreign key to link with leases table (assuming a relationship)
            $table->unsignedBigInteger('lease_id');
            // Annex Document Fields
            $table->string('inventory_of_premises_annex')->nullable();
            $table->string('inventory_of_furnishings_annex')->nullable();
            $table->string('furniture_inventory_annex')->nullable();
            $table->string('co_ownership_regulations_annex')->nullable();
            $table->string('student_mobility_lease_justification_annex')->nullable();
            $table->string('specific_lease_justification_annex')->nullable();
            $table->string('technical_diagnostics_ddt_annex')->nullable();
            $table->string('landlords_bank_details_annex')->nullable();
            $table->string('other_lease_related_documents')->nullable();
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lease_documents');
    }
};
