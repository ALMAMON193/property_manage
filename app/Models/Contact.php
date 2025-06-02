<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'user_id',
        'created_by_id',
        'type',
        'category',
        'additional_info',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function representative()
    {
        return $this->hasOne(EntityRepresentative::class);
    }

    public function entityContacts()
    {
        return $this->hasMany(EntityContact::class);
    }


}
