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
        Schema::create('lease_financial_conditions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lease_id');
            $table->decimal('rent_amount', 10, 2)->nullable();
            $table->date('rent_payment_due_date')->nullable();
            $table->string('rent_payment_frequency')->nullable();
            $table->string('preferred_rent_payment_method')->nullable();
            $table->text('other_accepted_payment_methods')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lease_financial_conditions');
    }
};
