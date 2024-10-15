<?php

namespace App\Models;

use App\Models\Product\Order;
use App\Models\Product\Comment;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'token',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function tires()
    {
        return $this->hasMany(Tires::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function paymentCards(): HasMany
    {
        return $this->hasMany(PaymentCard::class);
    }

}
