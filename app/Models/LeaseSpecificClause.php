<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaseSpecificClause extends Model
{
    protected $fillable = [
        'lease_id',
        'grounds_for_termination_clause',
        'type_of_use_of_leased_property',
        'key_money_amount',
        'legal_qualification_key_money',
        'value_of_lease_right',
        'conditions_for_assignment_of_lease_right',
    ];

    protected $casts = [
        'key_money_amount' => 'decimal:2',
        'value_of_lease_right' => 'decimal:2',
    ];

    // Relationship with Lease model
    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}
