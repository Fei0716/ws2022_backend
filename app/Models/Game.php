<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        $latestVersion = $this->gameVersions()->orderBy('id' ,'desc')->first();
        $path = $latestVersion->path;
        return $path;
    }
    // relationships
    public function gameVersions(){
        return $this->hasMany(GameVersion::class);
    }
    public function author(){
        return $this->belongsTo(User::class, 'author_id' ,'id');
    }
    // change route key
    public function getRouteKeyName(){
        return 'slug';
    }
}
