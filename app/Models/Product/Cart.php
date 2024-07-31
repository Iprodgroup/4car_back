<?php

namespace App\Models\Product;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tires_id',
        'disk_id',
        'quantity',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tires(): BelongsTo
    {
        return $this->belongsTo(Tires::class);
    }

    public function disks(): BelongsTo
    {
        return $this->belongsTo(Disk::class);
    }
    public function getTotalPriceAttribute(): float|int
    {
        $totalPrice = 0;

        if ($this->tire) {
            $totalPrice += $this->tire->price * $this->quantity;
        }

        if ($this->disk) {
            $totalPrice += $this->disk->price * $this->quantity;
        }

        return $totalPrice;
    }

}
