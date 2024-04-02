<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class GameScore extends Model
{
    use HasFactory;

    public $fillable =[
        'user_id',
        'game_version_id',
        'score'
    ];
    //method
    public function getHighestScore($id){
        $highestScore = GameScore::where([
            'game_version_id'=> $this->game_version_id ,
            'user_id' => $id,
        ])->max('score');
        return $highestScore;
    }
    public function getHighestScoreTimestamp($id){
        $highestScoreTimestamp = GameScore::where([
          'game_version_id'=> $this->game_version_id,
          'score' => $this->getHighestScore($id),
          'user_id' => $id,
        ])
        ->pluck('created_at')
        ->first();
        return $highestScoreTimestamp;
    }
    // relationship
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function gameVersion(){
        return $this->belongsTo(GameVersion::class)->withTrashed();
    }
}
