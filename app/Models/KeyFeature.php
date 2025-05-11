<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyFeature extends Model
{
    protected $table = 'key_features';
    protected $fillable = [
        'category_id',
        'caliber_names',
        'bullet_type',
        'muzzle_velocity',
        'muzzle_energy',
        'compatibility',
        'use_case',
        'image',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
