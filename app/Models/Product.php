<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'category',
        'price',
    ];

    /**
     * Get all order items for this product
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
