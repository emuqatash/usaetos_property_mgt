<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenantContractRequest;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\TenantContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TenantContractController extends Controller
{
    public function show(Request $request, $tenantId)
    {
        $tenantContracts = TenantContract::query()
            ->with('property')
            ->where('tenant_id', $tenantId)
            ->when($request->input('search'), function ($query, $search) {
                $query
                    ->where('contract_no', 'like', "%{$search}%")
                    ->orWhere('residential_tenancy_agreement', 'like', "%{$search}%");
            })
            ->orderBy('end_date', 'desc')
            ->paginate(5)
            ->withQueryString()
            ->through(fn($tenantContract) => [
                'id' => $tenantContract->id,
                'contract_no' => $tenantContract->contract_no,
                'residential_tenancy_agreement' => $tenantContract->residential_tenancy_agreement,
                'start_date' => Carbon::parse($tenantContract->start_date)->format('d-M-Y'),
                'end_date' => Carbon::parse($tenantContract->end_date)->format('d-M-Y'),
                'property_no' => $tenantContract->property->property_no,
            ]);

        $tenant = Tenant::find($tenantId);
        $properties = Property::all()->toArray();
        return Inertia('TenantContract/Show', compact('tenant', 'tenantContracts', 'properties'));
    }

    public function store(StoreTenantContractRequest $request)
    {
        $tenantContract = $request->all();
        if ($request->input('id') > 0) {
            $tenantContract_data = $request->all();
            $tenantContract = TenantContract::find($request->input('id'));
            $tenantContract->update($tenantContract_data);
        } else {
            $tenantContract['company_id'] = Auth::user()->company_id;
            $tenantContract['country_id'] = Auth::user()->country_id;
            $tenantContract = TenantContract::create($tenantContract);
        }

        if ($request->hasfile('attachmentFiles')) {
            $userId = Auth::user()->id;
            $tenantContractId = $tenantContract->id;
            $companyId = Auth::user()->company_id;
            foreach ($request->file('attachmentFiles') as $file) {
                $attachmentFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $file->getClientOriginalExtension();
                $attachmentFilePath = $file->storeAs('public/tenantContract_attachment_files/'.$companyId .'/'. $userId . '/' . $tenantContractId, $attachmentFileName);
                $tenantContract->tenantContractAttachmentFiles()->create([
                    'company_id' => Auth::user()->company_id,
                    'attachment_file_name' => $attachmentFileName,
                    'attachment_file' => $attachmentFilePath,
                ]);
            }
        }
        return redirect()->route('tenant-contract.show', $tenantContract->tenant_id);
    }

    public function createTenantContract($tenant_id)
    {
        $properties = Property::all()->toArray();
        return Inertia('TenantContract/Edit',
            ['properties' => $properties,'tenant_id' => $tenant_id,]);
    }
    public function edit($tenantContract_id)
    {
        $tenantContracts = TenantContract::find($tenantContract_id);
//        dd($tenantContracts);
        $tenantContracts->load('tenantContractAttachmentFiles');
        $properties = Property::all()->toArray();
        return Inertia('TenantContract/Edit',
            ['properties' => $properties,'tenantContracts' => $tenantContracts]);
    }

    public function destroy(TenantContract $tenantContract)
    {
        $tenantContract->delete();
        return redirect()->route('tenant-contract.show', $tenantContract->tenant_id);
    }

    public function duplicate($id)
    {
        $original = TenantContract::find($id);
        $duplicate = $original->replicate();
        $duplicate->save();
        return redirect()->route('tenant-contract.show', $original->tenant_id);
    }
}
