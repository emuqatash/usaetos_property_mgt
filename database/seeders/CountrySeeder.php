<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = [
            ['iso_code' => 'USA', 'name' => 'United States'],
            ['iso_code' => 'UAE', 'name' => 'United Arab Emirates']
            // add more countries here
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
