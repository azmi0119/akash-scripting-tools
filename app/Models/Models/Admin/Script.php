<?php

namespace App\Models\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Script extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
        'cart_addon',
        'host',
        'tracking_time',
        'convert_click',
        'device_type',
        'social_media',
        'tracking_one_url',
        'main_domain',
        'off_location',
        'country'
    ];

    protected $casts = [
        'device_type'   => 'array',
        'social_media'  => 'array',
        'country'       => 'array',
    ];
}
