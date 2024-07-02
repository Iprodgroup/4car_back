<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reviews extends Model
{
    use HasFactory;

    protected $fillable = [
        'tires_id',
        'user_id',
        'rating',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tires(): BelongsTo
    {
        return $this->belongsTo(Tires::class);
    }
}
