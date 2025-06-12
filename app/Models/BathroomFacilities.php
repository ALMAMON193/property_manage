<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BathroomFacilities extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'shower',
        'shower_type',
        'bathtub',
        'bathtub_type',
        'washbasin',
        'washbasin_type',
        'wc',
        'wc_type',
        'towel_dryers',
        'mirror',
        'bathroom_lighting',
        'washbasin_furniture',
        'cupboards',
    ];

    protected $casts = [
        'shower' => 'boolean',
        'bathtub' => 'boolean',
        'washbasin' => 'boolean',
        'wc' => 'boolean',
        'towel_dryers' => 'boolean',
        'mirror' => 'boolean',
        'bathroom_lighting' => 'boolean',
        'washbasin_furniture' => 'boolean',
        'cupboards' => 'boolean',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
