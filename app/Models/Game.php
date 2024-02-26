<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Game extends Model
{
    use HasFactory,SoftDeletes;

    //to generate attributes
    public function getThumbnailAttribute(){
        if(file_exists(public_path($this->getGameDirectoryPathAttribute().'/thumbnail.png'))){
            return $this->getGameDirectoryPathAttribute().'/thumbnail.png';
        }
        return null;
    }
    public function getGameDirectoryPathAttribute(){
        if($this->latestVersion){
            $path = $this->latestVersion->path;
            return $path;
        }
        return null;
    }
    public function getUploadTimestampAttribute(){
        if ($this->latestVersion){
            return $this->latestVersion->created_at;
        }
        return null;
    }
    public function getScoreCountAttribute(){
        $score = GameScore::select(DB::raw('COUNT(game_scores.id) as scoreCount'))
        ->join('game_versions' , 'game_versions.id' , 'game_scores.game_version_id')
        ->where('game_versions.game_id' , $this->id)
        ->first();

        return $score->scoreCount ?? 0;
    }
    // relationships
    public function gameVersions(){
        return $this->hasMany(GameVersion::class);
    }
    public function gameScores(){
        return $this->hasManyThrough( GameScore::class,GameVersion::class );
    }
    public function latestVersion(){
        return $this->hasOne(GameVersion::class)->where('deleted_at' , null);
    }
    public function author(){
        return $this->belongsTo(User::class, 'author_id' ,'id');
    }
    // change route key
    public function getRouteKeyName(){
        return 'slug';
    }
}
