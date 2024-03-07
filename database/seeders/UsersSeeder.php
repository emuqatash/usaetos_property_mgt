<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'company_id' => 1,
                'role_id' => 1,
                'name' => 'ed muqatash',
                'email' => 'emuqatash@gmail.com',
                'password' => Hash::make('password'),
                'remember_token' => '$2y$10$tThM2Wo1lagbGQTEzkpd2OXCNUGrB59zrFJV9Q4gXbvNN2sBjs0EO',
                'created_at' => Carbon::parse('1/27/2024 0:03'),
                'updated_at' => Carbon::parse('2/21/2024 20:45')
            ],
            [
                'id' => 2,
                'company_id' => 1,
                'role_id' => 2,
                'name' => 'salesman1',
                'email' => 'salesman1@gmail.com',
                'password' => Hash::make('password'),
                'remember_token' => '$2y$10$tThM2Wo1lagbGQTEzkpd2OXCNUGrB59zrFJV9Q4gXbvNN2sBjs0EO',
                'created_at' => Carbon::parse('1/27/2024 0:03'),
                'updated_at' => Carbon::parse('2/21/2024 20:45')
            ],
            [
                'id' => 3,
                'company_id' => 1,
                'role_id' => 2,
                'name' => 'salesman2',
                'email' => 'salesman2@example.com',
                'password' => Hash::make('password'),
                'remember_token' => '$2y$10$tThM2Wo1lagbGQTEzkpd2OXCNUGrB59zrFJV9Q4gXbvNN2sBjs0EO',
                'created_at' => Carbon::parse('1/27/2024 0:03'),
                'updated_at' => Carbon::parse('2/21/2024 20:45')
            ],
            // ... insert additional users here
        ];
        DB::table('users')->insert($users);
    }
}
