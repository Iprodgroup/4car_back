<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Product\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'date', 'description', 'text', 'image'];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function getShortDescriptionAttribute(): string
    {
        return Str::words($this->description, 10, '...');
    }
}
