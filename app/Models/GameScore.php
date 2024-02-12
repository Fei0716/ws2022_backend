<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class GameScore extends Model
{
    use HasFactory,SoftDeletes;


    // relationship
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function gameVersion(){
        return $this->belongsTo(GameVersion::class);
    }
}
