<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate the contacts table to clear any existing data
        DB::table('contacts')->truncate();

        // Create dummy contact data
        $contacts = [
            [
                'first_name' => 'Chris',
                'last_name' => 'Samaa',
                'contact_type_id' => 1,
                'phone_number' => '123-456-7890',
                'email' => 'johndoe1@example.com',
                'address' => '123 Main St',
                'city' => 'Prosper',
                'state_id' => 1,
                'zip' => '98765',
                'company_id' => 1,
                'profile_photo_path' => null,
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'contact_type_id' => 2,
                'phone_number' => '123-456-7890',
                'email' => 'johndoe2@example.com',
                'address' => '123 Main St',
                'city' => 'Allen',
                'state_id' => 2,
                'zip' => '98765',
                'company_id' => 1,
                'profile_photo_path' => null,
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'contact_type_id' => 3,
                'phone_number' => '987-654-3210',
                'email' => 'janesmith@example.com',
                'address' => '456 Elm St',
                'city' => 'Littel Elim',
                'state_id' => 3,
                'zip' => '98765',
                'company_id' => 1,
                'profile_photo_path' => null,
            ],
            [
                'first_name' => 'Peter',
                'last_name' => 'Jones',
                'contact_type_id' => 4,
                'phone_number' => '555-1212',
                'email' => 'peterjones@example.com',
                'address' => '789 Oak St',
                'city' => 'Oklohoma City',
                'state_id' => 4,
                'zip' => '98765',
                'company_id' => 1,
                'profile_photo_path' => null,
            ],
            [
                'first_name' => 'Mary',
                'last_name' => 'Brown',
                'contact_type_id' => 5,
                'phone_number' => '333-444-5555',
                'email' => 'marybrown@example.com',
                'address' => '1011 Maple St',
                'city' => 'Frisco',
                'state_id' => 5,
                'zip' => '98765',
                'company_id' => 1,
                'profile_photo_path' => null,
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Williams',
                'contact_type_id' => 1,
                'phone_number' => '222-333-4444',
                'email' => 'davidwilliams@example.com',
                'address' => '1213 Pine St',
                'city' => 'Dallas',
                'state_id' => 6,
                'zip' => '98765',
                'company_id' => 1,
                'profile_photo_path' => null,
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Miller',
                'contact_type_id' => 5,
                'phone_number' => '111-222-3333',
                'email' => 'sarahmiller@example.com',
                'address' => '1415 Elm St',
                'city' => 'Plano',
                'state_id' => 7,
                'zip' => '98765',
                'company_id' => 1,
                'profile_photo_path' => null,
            ],
            [
                'first_name' => 'Ed',
                'last_name' => 'Muq',
                'contact_type_id' => 1,
                'phone_number' => '469-222-8524',
                'email' => 'ed3@example.com',
                'address' => '1415 Daldor St',
                'city' => 'Celina',
                'state_id' => 7,
                'zip' => '75007',
                'company_id' => 1,
                'profile_photo_path' => null,
            ],
        ];

        // Insert dummy contact data into the contacts table
        DB::table('contacts')->insert($contacts);
    }
}
