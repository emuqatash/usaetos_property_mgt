<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyExpenseCategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Repair', 'Phone', 'Electricity', 'Water', 'Advertising', 'Insurance', 'Spare Parts',
            'Commission', 'Legal', 'Office Supplies', 'Management Fees', 'Other'];

        foreach($categories as $category)
        {
            DB::table('property_expense_categories')->insert([
                'name' => $category,
                'company_id' => 1
            ]);
        }
    }
}
