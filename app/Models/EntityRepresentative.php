<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityRepresentative extends Model
{
    protected $table = 'entity_representatives';

    protected $fillable = [
        'contact_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'place_of_birth',
        'address_line_1',
        'address_line_2',
        'country',
        'city',
        'postal_code',
        'siren',
        'website_url',
    ];


    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
