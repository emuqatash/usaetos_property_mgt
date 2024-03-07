<?php

namespace Database\Seeders;

use App\Models\Contact;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;


class ContactSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 6; $i++) {
            Contact::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'contact_type_id' => $faker->numberBetween(1, 2),
                'phone_number_1' => $faker->e164PhoneNumber,
                'email' => $faker->safeEmail,
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'state_id' => $faker->numberBetween(1, 50),
                'zip' => $faker->postcode,
                'company_id' => 1,
            ]);
        }
    }
}
