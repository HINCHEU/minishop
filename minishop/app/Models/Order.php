<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id'; // matches your table

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'total_amount',
    ];

    //public $timestamps = false; // your table only has created_at, no updated_at
}
