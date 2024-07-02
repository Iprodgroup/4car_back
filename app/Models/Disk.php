<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disk extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'model', 'weight',  'height', 'diametr',
        'season', 'spikes', 'index_n', 'index_s', 'run_flat','image',
    ];
}
