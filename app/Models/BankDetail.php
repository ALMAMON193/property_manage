<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    protected $table = 'bank_details';

    protected $fillable = [
        'user_id',
        'name',
        'rib_iban',
        'bic_swift',
        'address_line_1',
        'address_line_2',
        'country',
        'city',
        'postal_code',
    ];

// Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
