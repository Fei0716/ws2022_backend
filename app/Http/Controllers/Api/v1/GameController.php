<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Game;
use App\Models\GameVersion;
use App\Models\GameScore;
use App\Http\Resources\GameResource;
use App\Http\Resources\GameListResource;
use ZipArchive;
use Laravel\Sanctum\PersonalAccessToken;

class GameController extends Controller
{
    function index(Request $request){
        $validated = $request->validate([
            'page' => 'integer|min:0',
            'size' => 'integer|min:1',
            'sortBy' => 'in:title,popular,uploaddate',
            'sortDir' => 'in:asc,desc',
        ]);
        $page = (int)$request->get('page' , 0);
        $size = (int)$request->get('size' , 1);
        $sortBy = $request->get('sortBy' , 'title');
        $sortDir = $request->get('sortDir' , 'asc');


        $sortByCol = 'title';
        if($sortBy == 'popular'){
            $sortByCol = 'scoreCount';
        }else if ($sortBy == 'uploaddate'){
            $sortByCol = 'game_versions.created_at';
        }

        $games = Game::select('games.id', 'games.*')
        ->join('game_versions', 'game_versions.game_id', '=', 'games.id')
        ->whereNull('game_versions.deleted_at')
        ->skip($page * $size)
        ->take($size)
        ->orderBy($sortByCol, $sortDir)
        ->distinct('games.id')
        ->get();

        return [
            'page' => $page,
            'size' => $size,
            'totalElements' => $games->count(),
            'content' => GameListResource::collection($games),
        ];

    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|min:3|max:60',
            'description' => 'required|min:0|max:200',
        ]);
        //to create a slug
        $slug = explode(" ",$validated['title']);
        $slug = strtolower(implode("-" , $slug));
        // check uniqueness of slug
        if(Game::where('slug', $slug)->first()){
            return response()->json([
                'status' => 'invalid',
                'slug' => "Game title already exist",
            ], 400);
        }else{
            $game = new Game();
            $game->title = $validated['title'];
            $game->description = $validated['description'];
            $game->slug = $slug;
            $game->author_id = $request->user()->id;
            $game->save();

            return response()->json([
                'status' => "success",
                'slug' => $slug,
            ],201);
        }
    }

    public function show(Game $game){
        return response()->json(new GameResource($game), 200);
    }

    public function getGameFile(Game $game, $version){
        $gamePath = $game->gameVersions->where('version', $version)->pluck('path')->first();
        return response()->json([
            'path' => $gamePath,
        ],200);
    }

    public function update(Game $game, Request $request){
        $validated = $request->validate([
            'title' => 'required|min:3|max:60',
            'description' => 'required|min:0|max:200',
        ]);
        // check whether user is the author
        if($request->user()->username == $game->author->username){
            $game->title = $validated['title'];
            $game->description = $validated['description'];
            $game->save();

            return response()->json([
                'status' => 'success',
            ],200);
        }else{
            return response()->json([
                'status' => 'forbidden',
                'message'=> 'You are not the game author',
            ],403);
        }
    }

    public function destroy(Game $game, Request $request){
        // check whether user is the author
        if($request->user()->username == $game->author->username){
            // delete game scores and versions
            foreach($game->gameVersions as $version){
                $versionScores  =  $version->gameScores;
                foreach($versionScores as $score){
                    $score->delete();
                }
                $version->delete();
            }

            // delete the game
            $game->delete();

            return response()->json('',204);
        }else{
            return response()->json([
                'status' => 'forbidden',
                'message'=> 'You are not the game author',
            ],403);
        }
    }
    public function uploadGameFile(Game $game, Request $request){
        if($request->user()->username != $game->author->username){
            return response()->json([
                'status' => 'forbidden',
                'message'=> 'You are not the game author',
            ],403);
        }
        if ($game->latestVersion !== null) {
            $gameVersion = $game->latestVersion->version;
        } else {
            $gameVersion = 'V0';
        }
        $newGameVersion = intval(preg_replace('/V/i' ,'' ,$gameVersion)) + 1;
        $file = $request->validate([
            'zipfile' => 'required',
        ])['zipfile'];
        // Check file size
        $maxFileSize = 10 * 1024 * 1024; // 10 MB
        if ($file->getSize() > $maxFileSize) {
            return response()->plainText('File size too big', 400);
        }
        $zip = new ZipArchive();
        if (!$zip->open($file->getRealPath())) {
            return response()->plainText('ZIP file cannot be extracted', 400);
        }
        $path = 'games/'.$game->id.'/v'.$newGameVersion;
        if(!file_exists(public_path($path))){
            mkdir(public_path($path), 0777, true);
        }

        $zip->extractTo($path);
        $zip->close();

        // delete old versions
        foreach(GameVersion::where('game_id', $game->id)->get() as $oldVersion){
            $oldVersion->delete();
        }

        $gameVersion = new GameVersion();
        $gameVersion->version = "v".strval($newGameVersion);
        $gameVersion->game_id = $game->id;
        $gameVersion->path = $path;
        $gameVersion->save();

        return response()->json([
            'status' => 'Upload Successful',
        ],201);
    }
}
