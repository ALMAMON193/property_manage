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
        Schema::create('lease_specific_clauses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lease_id');
            $table->text('grounds_for_termination_clause')->nullable();
            $table->string('type_of_use_of_leased_property')->nullable();
            $table->decimal('key_money_amount', 10, 2)->nullable();
            $table->string('legal_qualification_key_money')->nullable();
            $table->decimal('value_of_lease_right', 10, 2)->nullable();
            $table->text('conditions_for_assignment_of_lease_right')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lease_specific_clauses');
    }
};
