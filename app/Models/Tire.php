<?php

namespace App\Models;

use App\Models\Product\Cars;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tire extends Model
{
    use HasFactory;
    protected $fillable = [
        'status', 'code', 'description', 'is_replica', 'shirina', 'visota', 'diametr', 'item', 'ext_code',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function car()
    {
        return $this->belongsTo(Cars::class, 'item', 'id');
    }
}
