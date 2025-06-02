<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityAccess extends Model
{
    protected $table = 'entity_accesses';
    protected $fillable = [
        'entity_id',
        'user_id',
    ];


    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
}
