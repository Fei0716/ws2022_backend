<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::withTrashed()->get();
        return view('game.index')->with(['games'=>$games]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {   
        return view('game.show')->with(['game'=>$game]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();//softDelete
        return redirect()->back();
    }
}
