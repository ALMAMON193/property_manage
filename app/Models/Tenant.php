<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table = 'tenants';
    protected $fillable = [
        'lease_id',
        'type',
        'category',
        'additional_info',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }



}
