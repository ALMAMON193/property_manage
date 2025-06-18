<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentRevisionCondition extends Model
{
    protected $fillable = [
        'lease_id',
        'rent_revision_type',
        'revision_frequency',
        'date_of_last_revision',
        'reference_index',
        'other_index_to_specify',
        'index_reference_quarter',
        'index_reference_year',
        'reference_index_value',
        'revision_formula',
    ];
    protected $casts = [
        'date_of_last_revision' => 'date',
        'reference_index_value' => 'decimal:2',
    ];
    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}
