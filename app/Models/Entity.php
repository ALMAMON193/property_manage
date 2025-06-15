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


    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'entity_accesses');
    }

    public function entityAccesses()
    {
        return $this->hasMany(EntityAccess::class);
    }

    public function buildings()
    {
        return $this->hasMany(Building::class, 'entity_id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'entity_id');
    }

}
