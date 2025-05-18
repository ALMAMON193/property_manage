<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'app_name',
        'tagline',
        'logo',
        'footer_logo',
        'favicon',
        'phone',
        'email',
        'address',
        'footer_description',
        'copy_right_text',
        'meta_keywords',
        'meta_description',
    ];
}
