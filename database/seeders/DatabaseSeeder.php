<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
//            UsersTableSeeder::class,
            CompanySeeder::class,
            StatesSeeder::class,
            ContactTypeSeeder::class,
            InsuranceAgentSeeder::class,
            RoleSeeder::class,
            ContactSeeder::class,
            // ... other seeders
        ]);
    }
}
