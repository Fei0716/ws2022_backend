<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    // attributes
    public static $BLOCKED_REASONS =[
        'spamming' => 'You have been blocked for spamming',
        'cheating' => 'You have been blocked for cheating',
        'other' => 'You have been blocked by an administrator',
    ];
    // modify the route key
    public function getRouteKeyName(){
        return 'username';
    }

    // relationships
    public function gameScores(){
        return $this->hasMany(GameScore::class);
    }
    public function games(){
        return $this->hasMany(Game::class ,'author_id' , 'id');
    }
}
