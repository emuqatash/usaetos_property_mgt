<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $contract = "TEXAS LAW HB 2102: Texas law requires a person insured under a property insurance policy to pay any deductible applicable to a claim made under the policy. It is a violation of this Texas law for a person or business paid wholly or partly from proceeds of a property insurance claim to knowingly allow the insured person to fail to pay, or assist the insured person's failure to pay, the applicable insurance deductible.

Andrus Brothers Roofing, my contractor, has my consent to contact my insurance carrier to discuss their appraisal if needed. Supplements approved by my carrier will become part of this contract.

All material is guaranteed to be as specified. All work is to be completed in a workmanlike manner according to standard industry practice. All agreements are contingent upon strikes, accidents or delays beyond our control. Late payments are subject to 1.5% per month late penalty charge. Warranty and certification valid only upon payment in full. Material warranty is from manufacturer, labor warranty is from Andrus Brothers Roofing. Owner is responsible for bad decking or other 'hidden damage' requiring repair or replacement. Price increases beyond Andrus Brothers Roofing's control to be determined and approved by insurance carrier if applicable. Andrus Brothers Roofing is not responsible for hidden damage, such as bad or non nailable roof decking or broken plank decking; nor is Andrus Brothers roofing responsible for concealed, unseen items installed in the attic within one inch of the roof deck. The homeowner may cancel this contract at any time prior to midnight of the third business day of execution.";

        Company::updateOrCreate([
            'name' => 'Us Aetos',
            'address' => '210 County Rd 7200, Lubbock, TX 79404',
            'contract_details' => $contract,
        ]);

        $secondCompanyContract = "Another Contract Details to be added by amjad...";  // Replace with actual contract

        Company::updateOrCreate([
            'name' => 'NewBytic',   // Replace with actual name
            'address' => 'NewYor, Yonkers Zipcode : 458654',  // Replace with actual address
            'contract_details' => $secondCompanyContract,
        ]);

    }
}
