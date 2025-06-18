<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentAutomationSetting extends Model
{
    protected $fillable = [
        'lease_id',
        'generate_rents_from_date',
        'tenant_balance',
        'automatic_rent_revision',
        'automatic_sending_of_rent_receipt',
        'automatic_sending_of_rent_call',
        'automatic_sending_of_first_reminder',
        'automatic_sending_of_second_reminder',
        'automatic_sending_of_third_reminder',
        'rent_call_sending_date',
        'first_unpaid_rent_reminder_sending_date',
        'first_unpaid_rent_reminder_days_after',
        'second_unpaid_rent_reminder_sending_date',
        'second_unpaid_rent_reminder_days_after',
        'third_unpaid_rent_reminder_sending_date',
        'third_unpaid_rent_reminder_days_after',
    ];

    protected $casts = [
        'tenant_balance' => 'decimal:2',
        'generate_rents_from_date' => 'date',
        'rent_call_sending_date' => 'date',
        'first_unpaid_rent_reminder_sending_date' => 'date',
        'second_unpaid_rent_reminder_sending_date' => 'date',
        'third_unpaid_rent_reminder_sending_date' => 'date',
        'automatic_rent_revision' => 'boolean',
        'automatic_sending_of_rent_receipt' => 'boolean',
        'automatic_sending_of_rent_call' => 'boolean',
        'automatic_sending_of_first_reminder' => 'boolean',
        'automatic_sending_of_second_reminder' => 'boolean',
        'automatic_sending_of_third_reminder' => 'boolean',
    ];

    // Relationship with Lease model
    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}
