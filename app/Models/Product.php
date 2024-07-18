<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [ 'name', 'category','vendor', 'height',
                            'diameter', 'weight', 'load_index', 'speed_index',
                            'model', 'run_flat', 'volume', 'season', 'spikes', 'width',
                            'price', 'price', 'overhang', 'count_bolt', 'spacing_bolt',
                            'hole', 'type', 'colour'];



}
