<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        ];

        DB::table('users')->insert($users);

        $user = User::find(1); // Retrieve the user we just inserted
        if($user) {
            $user->assignRole(['Admin', 'Superuser']);
        }
    }
}
