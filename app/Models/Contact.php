<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'company_name',
        'email',
        'phone',
        'comment',
        'not_a_robot',
    ];

    // Attribute casting
    protected $casts = [
        'company_name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'comment' => 'string',
        'not_a_robot' => 'boolean',
    ];
}
