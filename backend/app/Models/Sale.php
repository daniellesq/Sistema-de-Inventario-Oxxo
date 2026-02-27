<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    // ESTO FALTABA: Permitir que se llenen estos campos
    protected $fillable = ['user_id', 'total'];

    // Relación: Una venta tiene muchos detalles
    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}