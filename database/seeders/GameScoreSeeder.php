<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Game;
use App\Models\GameVersion;

class GameScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dev1 = User::where('username' , 'dev1')->first()->id;
        $dev2 = User::where('username' , 'dev2')->first()->id;
        $player1 = User::where('username' , 'player1')->first()->id;
        $player2 = User::where('username' , 'player2')->first()->id;

        $game1 = Game::where('title' , 'Demo Game 1')->first();
        $game2 = Game::where('title' , 'Demo Game 2')->first();

        $game1v1 = GameVersion::where('game_id' , $game1->id)->withTrashed()->orderBy('created_at')->first();
        $game1v2 = GameVersion::where('game_id' , $game1->id)->withTrashed()->orderBy('created_at' , 'desc')->first();
        $game2v1 = GameVersion::where('game_id' , $game2->id)->withTrashed()->orderBy('created_at' , 'asc')->first();


        DB::table('game_scores')->insert([
            [
                'user_id' => $player1,
                'game_version_id' => $game1v1->id,
                'score' => 10.0,
                'created_at' => Carbon::now(),
            ],
            [
                'user_id' => $player1,
                'game_version_id' => $game1v1->id,
                'score' => 15.0,
                'created_at' => Carbon::now(),
            ],
            [
                'user_id' => $player1,
                'game_version_id' => $game1v2->id,
                'score' => 12.0,
                'created_at' => Carbon::now(),
            ],

            [
                'user_id' => $player2,
                'game_version_id' => $game1v2->id,
                'score' => 20.0,
                'created_at' => Carbon::now(),
            ],
            [
                'user_id' => $player2,
                'game_version_id' => $game2v1->id,
                'score' => 30.0,
                'created_at' => Carbon::now(),
            ],

            [
                'user_id' => $dev1,
                'game_version_id' => $game1v2->id,
                'score' => 1000.0,
                'created_at' => Carbon::now(),
            ],
            [
                'user_id' => $dev1,
                'game_version_id' => $game1v2->id,
                'score' => -300.0,
                'created_at' => Carbon::now(),
            ],

            [
                'user_id' => $dev2,
                'game_version_id' => $game1v2->id,
                'score' => 5.0,
                'created_at' => Carbon::now(),
            ],
            [
                'user_id' => $dev2,
                'game_version_id' => $game2v1->id,
                'score' => 200.0,
                'created_at' => Carbon::now(),
            ],

        ]);
    }
}
