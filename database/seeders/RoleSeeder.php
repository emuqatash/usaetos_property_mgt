<?php

namespace Database\Seeders;

//use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
//        Role::updateOrCreate(['name' => 'Administrator']);
//        Role::updateOrCreate(['name' => 'Sales']);

        Role::updateOrCreate(['name' => 'Admin']);
        Role::updateOrCreate(['name' => 'Superuser']);
        Role::updateOrCreate(['name' => 'user']);
    }
}
