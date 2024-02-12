<?php

namespace Database\Seeders;

use App\Models\ContactType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contactTypes = [
            'Customer',
            'Salesman',
            'Agent/Adjuster',
            'Subcontractor',
            'Supplier',
        ];

        foreach ($contactTypes as $type) {
            ContactType::create([
                'name' => $type,
            ]);
        }
    }
}
