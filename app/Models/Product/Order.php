<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'number',
        'city',
        'district',
        'delively_method',
        'town',
        'adres',
        'orient',
        'work_adres',
        'phone',
        'comment',
        'coupon',
        'payment_method',
        'sum',
        'products',
        'status_id',
        ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
