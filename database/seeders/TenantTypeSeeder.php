<?php

namespace Database\Seeders;

use App\Models\TenantType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantTypeSeeder extends Seeder
{
    public function run(): void
    {
        $contactTypes = [
            'Stuff',
            'Non Stuff',
        ];

        foreach ($contactTypes as $type) {
            TenantType::create([
                'name' => $type,
                'company_id' => 1,
            ]);
        }
    }
}
