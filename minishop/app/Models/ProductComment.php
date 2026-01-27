<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    protected $table = 'product_comments';

    protected $fillable = [
        'product_id',
        'guest_name',
        'guest_email',
        'comment_text',
        'rating',
        'is_approved',
    ];

    /**
     * Get the product associated with the comment
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
