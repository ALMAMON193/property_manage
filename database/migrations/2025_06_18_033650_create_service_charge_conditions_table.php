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
        Schema::create('service_charge_conditions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lease_id');
            // Service Charge Details
            $table->string('type_of_charges')->nullable();
            $table->decimal('monthly_flat_rate_amount', 10, 2)->nullable();
            $table->text('fixed_charges_included')->nullable();
            $table->decimal('monthly_provision_for_actual_charges', 10, 2)->nullable();
            $table->text('types_of_actual_charges')->nullable();
            $table->text('procedures_for_regularization_of_actual_charges')->nullable();
            $table->text('distribution_of_charges_between_co_tenants')->nullable();

            // Specific Charges and Taxes Allocations
            $table->string('property_tax_allocation')->nullable();
            $table->string('co_ownership_charges_allocation')->nullable();
            $table->string('insurance_allocation')->nullable();
            $table->string('maintenance_repairs_allocation')->nullable();
            $table->string('taxes_and_fees_allocation')->nullable();

            // Other Allocation Options (Text Fields for Specificity)
            $table->text('other_property_tax_allocation')->nullable();
            $table->text('other_co_ownership_charges_allocation')->nullable();
            $table->text('other_insurance_allocation')->nullable();
            $table->text('other_maintenance_repairs_allocation')->nullable();
            $table->text('other_taxes_and_fees_allocation')->nullable();

            // Security Deposit
            $table->decimal('security_deposit', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_charge_conditions');
    }
};
