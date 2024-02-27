<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PlayerHighscoreResource;
use App\Models\Game;
use Illuminate\Support\Facades\DB;
use App\Models\GameScore;


class ScoreController extends Controller
{
    public function show(Game $game){
        $gameVersionsId = $game->gameVersions()->withTrashed()->pluck('id');
        // get all players highest score for this game
        $playerScores = GameScore::select('users.username', 'game_scores.created_at', 'game_scores.score as highestScore')
        ->join('users', 'users.id', '=', 'game_scores.user_id')
        ->whereIn('game_version_id', $gameVersionsId)
        ->orderBy('game_scores.score', 'desc')
        ->orderBy('game_scores.created_at', 'desc')
        ->get()
        ->unique('username');
    
        
        return response()->json([
            'scores' => PlayerHighscoreResource::collection($playerScores),
        ] , 200);
    }

    public function store(Game $game, Request $request){
        $latestVersion = $game->latestVersion;

        $score = new GameScore();
        $score->user_id = $request->user()->id;
        $score->game_version_id = $latestVersion->id;
        $score->score = $request->score;
        $score->save();

        return response()->json([
            'status' => 'success'
        ] , 200);
    }
}
