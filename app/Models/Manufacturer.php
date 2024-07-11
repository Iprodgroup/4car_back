<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Manufacturer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'slug', 'picture'];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($manufacturer) {
            $manufacturer->slug = Str::slug($manufacturer->name);
        });

        static::updating(function ($manufacturer) {
            $manufacturer->slug = Str::slug($manufacturer->name);
        });
    }

    public function getShortDescriptionAttribute(): string
    {
        return Str::words($this->description, 15, '...');
    }
}
