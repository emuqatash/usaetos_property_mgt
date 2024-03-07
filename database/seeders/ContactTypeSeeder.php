<?php

namespace Database\Seeders;

use App\Models\ContactType;
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

        foreach ($contactTypes as $type) {
            ContactType::create([
                'name' => $type,
                'company_id' => 1,
            ]);
        }
    }
}
