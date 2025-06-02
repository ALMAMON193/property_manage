<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityContact extends Model
{
    protected $table = 'entity_contacts';
    protected $fillable = [
        'entity_id',
        'user_id',
    ];


    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'user_id');
    }
}
