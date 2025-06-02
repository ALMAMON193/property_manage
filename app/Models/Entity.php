<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $table = 'entities';
    protected $fillable = [
        'user_id',
        'name',
        'type'
    ];

    public function contacts()
    {
        return $this->hasMany(EntityContact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
