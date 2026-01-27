<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopSetting extends Model
{
    protected $table = 'shop_settings';

    protected $fillable = [
        'shop_name',
        'logo_url',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'postal_code',
        'description',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
    ];

    /**
     * Get the first shop setting (there should only be one)
     */
    public static function getSettings()
    {
        return self::first() ?? self::create([
            'shop_name' => 'Mini-Shop',
            'phone' => '+1 (234) 567-890',
            'email' => 'support@minishop.com',
            'address' => '123 Shopping Street',
            'city' => 'Commerce City',
            'state' => 'ST',
            'postal_code' => '12345',
        ]);
    }
}
