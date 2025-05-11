<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $primaryKey = 'id';

    // Fillable fields for mass assignment
    protected $fillable = [
        'retailer_id',
        'title',
        'brand',
        'caliber',
        'limit',
        'price',
        'url',
        'quantity',
        'grains',
        'num_of_rounds',
        'cost_per_round',
        'condition',
        'casing',
    ];

    // Cast attributes to the correct data type
    protected $casts = [
        'price'         => 'float',
        'cost_per_round' => 'float',
    ];


    /*== accessor for cost_per_round ===*/
    public function getCostPerRoundAttribute($value)
    {
        return $value !== null ? number_format((float) $value, 3, '.', '') : null;
    }

    // Define relationship with Retailer model
    public function retailer()
    {
        return $this->belongsTo(Retailer::class, 'retailer_id');
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }
}
