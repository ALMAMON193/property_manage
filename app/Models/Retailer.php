<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    protected $table = 'retailers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'retailer_website',
        'data_url',
        'title',
        'update_interval',
        'status',
        'type',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }


}
