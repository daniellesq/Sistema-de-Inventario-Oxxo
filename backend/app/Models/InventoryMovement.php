<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'quantity',
        'reason'
    ];

    // Relación: Un movimiento pertenece a un Producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relación: Un movimiento pertenece a un Usuario (quien lo hizo)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}