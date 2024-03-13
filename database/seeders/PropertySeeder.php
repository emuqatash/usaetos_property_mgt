<?php

namespace Database\Seeders;

use App\Models\Property;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            Property::create([
                'property_no' => $faker->unique()->bothify('P-##??'), // Example: P-12AB
                'name' => $faker->words(3, true),
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'state_id' => $faker->numberBetween(1, 50), // assuming you have 50 states
                'zip' => $faker->postcode,
                'owner' => $faker->name,
                'ownership_rate' => $faker->numberBetween(2, 0, 100),
                'date_of_purchase' => $faker->date(),
                'area_size' => $faker->randomNumber(3),
                'number_of_bedrooms' => $faker->numberBetween(1, 5),
                'cost' => $faker->randomFloat(2, 100, 100000000),
                'payments_left' => $faker->numberBetween(1, 5),
                'handover_date' => $faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
                'property_status' => $faker->randomElement(['Vacant', 'Occupied', 'Rented', 'Under Maintenance']),
                'company_id' => $faker->numberBetween(1, 2),
                // timestamps will be added automatically by Eloquent
            ]);
        }
    }
}
