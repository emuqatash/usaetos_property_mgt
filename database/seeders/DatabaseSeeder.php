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
            CompanySeeder::class,
            StatesSeeder::class,
            ContactTypeSeeder::class,
            TenantTypeSeeder::class,
            InsuranceAgentSeeder::class,
            RoleSeeder::class,
            ContactSeeder::class,
            TenantSeeder::class,
            PropertySeeder::class,
            PropertyExpenseCategoriesSeeder::class,
            UsersSeeder::class,

            // ... other seeders
        ]);
    }
}
