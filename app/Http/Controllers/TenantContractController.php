<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenantRequest;
use App\Models\Property;
use App\Models\State;
use App\Models\Tenant;
use App\Models\TenantContract;
use App\Models\TenantType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TenantContractController extends Controller
{
    public function index(Request $request)
    {
        $tenantContracts = Cache::remember('articles', 60, function () use ($request) {
            return TenantContract::query()
                ->with('tenant')
                ->with('property')
                ->with('company')
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                })
                ->orderBy('first_name')
                ->paginate(10)
                ->withQueryString()
                ->through(fn($tenantContract) => [
                    'id' => $tenantContract->id,
                    'first_name' => $tenantContract->first_name,
                    'last_name' => $tenantContract->last_name,
                    'property_id' => $tenantContract->tenantType->propertyname,
                    'start_date' => $tenantContract->phone_number_1,
                    'end_date' => $tenantContract->phone_number_2,
                ]);
//            'counts' => [
//                'vacant' => Tenant::where('tenant_type_name', 'Vacant')->count(),
//                'occupied' => Tenant::where('tenant_type_name', 'Occupied')->count(),
//            ],
        });

        return Inertia('TenantContract/Index', [
            'tenantContracts' => $tenantContracts,
            'filters' => $request->only(['search']),
            'selectedTenantId' => (int)$request->input('selectedTenantId'),
        ]);
    }
    public function show($tenantId)
    {
        $tenantContracts = Tenant::find($tenantId);
        $tenantContracts->load('tenantContracts');
//        $properties = Property::select('id','name')->get()->toArray();
        $properties = Property::all()->toArray();
        return Inertia('TenantContract/Show', compact('tenantContracts', 'properties'));
    }

//    public function create()
//    {
//        return Inertia('TenantContract/Create');
//    }
    public function store(StoreTenantRequest $request)
    {
        $tenantContract = $request->all();
        if ($request->input('id') > 0) {
            $tenantContract_data = $request->all();
            $tenantContract = Tenant::find($request->input('id'));
            $tenantContract->update($tenantContract_data);
        } else {
            $tenantContract['company_id'] = Auth::user()->company_id;
            $tenantContract = Tenant::create($tenantContract);
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
        return redirect()->route('tenant-contract.index', ['selectedTenantId' => $tenantContract->id]);
    }

    public function edit($id)
    {
        dd('hi');
//        $tenantContract = Tenant::where('id', $tenantContract->id)
//        $job->load('property','tenant');
//        $tenantContract = TenantContract::where('id', $tenantContract->id)
//            ->with('tenantContractAttachmentFiles')
//            ->with('state')
//            ->first();
//        $states = State::all();
//        return Inertia('TenantContract/Create', [
//            'tenantContract' => $tenantContract,
//            'states' => $states,
//        ]);
    }

    public function destroy(TenantContract $tenantContract)
    {
        $tenantContract->delete();
        return redirect()->route('tenant-contract.index');
    }

    public function duplicate($id)
    {
        $original = TenantContract::find($id);
        $duplicate = $original->replicate();
        $duplicate->save();
        return redirect()->route('tenant-contract.index');
    }
}
