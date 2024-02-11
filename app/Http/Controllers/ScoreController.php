<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameScore;
use App\Models\Game;
use App\Models\User;

class ScoreController extends Controller
{
    // for deleting one score
    function destroy(GameScore $score){
        $score->delete();
        $score->save();

        return redirect()->back();
    }
    function destroyPlayer(User $user, Game $game){
        // delete all scores of a player for a game
        foreach($game->gameVersions as $version){
            GameScore::where([
                'game_version_id' => $version->id,
                'user_id'   => $user->id,
            ])
            ->delete();
        }
        return redirect()->back();

    }
    function destroyAll(Game $game){
        // reset all scores for a game and its versions
        foreach($game->gameVersions as $version){
            foreach($version->gameScores as $score){
                $score->delete();
            }
        }
        return redirect()->back();

    }
}
