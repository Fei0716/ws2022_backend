<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameVersion extends Model
{
    use HasFactory,SoftDeletes;

    // relationship
    public function gameScores(){
        return $this->hasMany(GameScore::class);
    }
    public function game(){
        return $this->belongsto(Game::class);
    }
}
