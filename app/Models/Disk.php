<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Disk extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'model', 'weight',  'height', 'diametr',
        'season', 'spikes', 'index_n', 'index_s', 'run_flat','image',
    ];

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
