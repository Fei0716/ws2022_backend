<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameVersion extends Model
{
    use HasFactory;

    // relationship
    public function gameScores(){
        return $this->hasMany(GameScore::class);
    }
}
