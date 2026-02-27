<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    'sku', 
    'name', 
    'description', 
    'price', 
    'stock', 
    'min_stock', 
    'image_url', 
    'is_active'
];
}
