<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            Tenant::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'tenant_type_id' => $faker->numberBetween(1, 2),
                'document_id' => $faker->numberBetween(100, 10000),
                'document2_id' => $faker->numberBetween(200, 20000),
                'phone_number_1' => $faker->e164PhoneNumber,
                'email' => $faker->safeEmail,
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'state_id' => $faker->numberBetween(1, 50),
                'zip' => $faker->postcode,
                'company_id' => $faker->numberBetween(1, 2),
            ]);
        }
    }
}
