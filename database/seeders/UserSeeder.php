<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'player1',
                'password' => Hash::make('helloworld1!'),
                'created_at' => Carbon::now(),
            ],
            [
                'username' => 'player2',
                'password' => Hash::make('helloworld2!'),
                'created_at' => Carbon::now(),
            ],
            [
                'username' => 'dev1',
                'password' => Hash::make('hellobyte1!'),
                'created_at' => Carbon::now(),
            ],
            [
                'username' => 'dev2',
                'password' => Hash::make('hellobyte2!'),
                'created_at' => Carbon::now(),
            ],
        ]);       
    }
}
