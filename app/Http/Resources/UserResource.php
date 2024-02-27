<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use App\Models\Game;
use App\Models\GameScore;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $authoredGames = Game::leftJoin('game_versions' ,'game_versions.game_id' ,'games.id')
        ->where('games.author_id', $this->id)
        ->where('game_versions.deleted_at' , null);

        // check whether the user is the author of the game
        if($request->user()->username != $this->username){
            $authoredGames = $authoredGames->whereNotNull('game_versions.id');
        }

        $authoredGames = $authoredGames->get();
        $highscores = GameScore::join('game_versions' , 'game_versions.id' , 'game_scores.game_version_id')
        ->join('games' ,'games.id' ,'game_versions.game_id')
        ->where([
            'game_scores.user_id' => $this->id,
        ]) 
        ->select(DB::raw('Max(score) as highestScore'),'game_scores.created_at' ,'games.slug' ,'games.title' ,'games.description')
        ->groupBy('game_scores.created_at','games.slug' ,'games.title' ,'games.description')
        ->get();


        return [
            'username' => $this->username,
            'registeredTimestamp' => $this->created_at,
            'authoredGames' => AuthoredGameResource::collection($authoredGames),
            'highscores' => HighscoreResource::collection($highscores),
        ];
    }
}
