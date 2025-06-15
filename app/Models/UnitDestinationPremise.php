<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitDestinationPremise extends Model
{
    protected $table = 'unit_destination_premises';

    protected $fillable = [
        'unit_id',
        'auth_com_act',
        'proh_com_act',
        'excl_clause',
        'auth_lib_prof',
        'proh_lib_prof',
        'excl_clause_prof',
        'auth_rel_act',
        'excl_veh_park_type',
        'proh_store',
        'spec_use_lot',
        'spec_proh_lot',
    ];

    protected $casts = [
        'excl_clause' => 'boolean',
        'excl_clause_prof' => 'boolean',
        'proh_store' => 'boolean',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
