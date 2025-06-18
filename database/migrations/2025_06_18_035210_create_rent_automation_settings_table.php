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
        Schema::create('rent_automation_settings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lease_id');
            // Rent Generation and Balance
            $table->date('generate_rents_from_date')->nullable();
            $table->decimal('tenant_balance', 10, 2)->nullable();
            $table->boolean('automatic_rent_revision')->default(false);

            // Automation Settings
            $table->boolean('automatic_sending_of_rent_receipt')->default(false);
            $table->boolean('automatic_sending_of_rent_call')->default(false);
            $table->boolean('automatic_sending_of_first_reminder')->default(false);
            $table->boolean('automatic_sending_of_second_reminder')->default(false);
            $table->boolean('automatic_sending_of_third_reminder')->default(false);

            // Reminder Sending Dates
            $table->date('rent_call_sending_date')->nullable();
            $table->date('first_unpaid_rent_reminder_sending_date')->nullable();
            $table->integer('first_unpaid_rent_reminder_days_after')->nullable();
            $table->date('second_unpaid_rent_reminder_sending_date')->nullable();
            $table->integer('second_unpaid_rent_reminder_days_after')->nullable();
            $table->date('third_unpaid_rent_reminder_sending_date')->nullable();
            $table->integer('third_unpaid_rent_reminder_days_after')->nullable();
            $table->timestamps();

           

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_automation_settings');
    }
};
