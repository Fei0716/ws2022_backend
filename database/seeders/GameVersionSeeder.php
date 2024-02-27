<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Game;

class GameVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $game1 = Game::where('title' , 'Demo Game 1')->first();
        $game2 = Game::where('title' , 'Demo Game 2')->first();

        DB::table('game_versions')->insert([
            [
                'version' => 'v1',
                'game_id' => $game1->id,
                'path' => 'games/'.$game1->id.'/v1',
                'created_at' => Carbon::now()->subHours(2),
                'deleted_at' => Carbon::now()->subHours(1)->subMinutes(2),
            ],
            [
                'version' => 'v2',
                'game_id' => $game1->id,
                'path' => 'games/'.$game1->id.'/v2',
                'created_at' => Carbon::now()->subHours(1),
                'deleted_at' => null,

            ],
            [
                'version' => 'v1',
                'game_id' => $game2->id,
                'path' => 'games/'.$game2->id.'/v1',
                'created_at' => Carbon::now()->subHours(1),
                'deleted_at' => null,
            ],
        ]);        
    }
}
