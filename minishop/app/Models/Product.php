<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image_url',
        'status'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
