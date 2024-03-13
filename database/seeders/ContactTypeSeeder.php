<?php

namespace Database\Seeders;

use App\Models\ContactType;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactTypeSeeder extends Seeder
{
    public function run(): void
    {
        $contactTypes = [
            'Salesman',
            'Agent',
        ];

        $faker = Faker::create();

        foreach ($contactTypes as $type) {
            ContactType::create([
                'name' => $type,
                'company_id' => $faker->numberBetween(1, 2),
            ]);
        }
    }
}
