<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;



class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin_users')->insert([
            [
                'username' => 'admin1',
                'password' => Hash::make('hellouniverse1!'),
                'registered_at' => Carbon::now(),
            ],
            [
                'username' => 'admin2',
                'password' => Hash::make('hellouniverse2!'),
                'registered_at' => Carbon::now(),
            ],
        ]);
    }
}
