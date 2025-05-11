<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingReview extends Model
{
    protected $table = 'shipping_reviews';
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'review',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
