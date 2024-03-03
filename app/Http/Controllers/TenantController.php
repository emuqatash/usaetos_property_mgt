<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\TenantType;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTenantRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $tenants = Cache::remember('articles', 60, function () use ($request) {
            return Tenant::query()
                ->with('tenantType')
                ->with('state')
                ->with('company')
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                })
                ->orderBy('first_name')
                ->paginate(0)
                ->withQueryString()
                ->through(fn($tenant) => [
                    'id' => $tenant->id,
                    'first_name' => $tenant->first_name,
                    'last_name' => $tenant->last_name,
                    'tenant_type_name' => $tenant->tenantType->name,
                    'phone_number_1' => $tenant->phone_number_1,
                    'phone_number_2' => $tenant->phone_number_2,
                    'email' => $tenant->email,
                    'address' => $tenant->address,
                    'city' => $tenant->city,
                    'state_name' => $tenant->state->name,
                    'zip' => $tenant->zip,
                    'document_id' => $tenant->document_id,
                    'company_name' => $tenant->company->name,
                    'profile_photo_path' => $tenant->profile_photo_path,
                    'remarks' => $tenant->remarks,
                ]);
//            'counts' => [
//                'vacant' => Tenant::where('tenant_type_name', 'Vacant')->count(),
//                'occupied' => Tenant::where('tenant_type_name', 'Occupied')->count(),
//            ],
        });

        return Inertia('Tenant/Index', [
            'tenant' => $tenants,
            'filters' => $request->only(['search']),
            'selectedTenantId' => (int)$request->input('selectedTenantId'),
        ]);
    }

    // Returns all 500 without Caching
//    public function allWithoutCache()
//    {
//        return Tenant::all();
//    }
    public function create()
    {
        $states = State::all();
        $tenantTypes = TenantType::all();
        return Inertia('Tenant/Create', compact('states', 'tenantTypes'));
    }
    public function store(StoreTenantRequest $request)
    {
        $tenant = $request->all();
        if ($request->input('id') > 0) {
            $tenant_data = $request->all();
            $tenant = Tenant::find($request->input('id'));
            $tenant->update($tenant_data);
        } else {
            $tenant['company_id'] = Auth::user()->company_id;
            $tenant = Tenant::create($tenant);
        }

        if ($request->hasfile('attachmentFiles')) {
            foreach ($request->file('attachmentFiles') as $file) {
                $attachmentFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $file->getClientOriginalExtension();
                $attachmentFilePath = $file->storeAs('public/tenant_attachment_files', $attachmentFileName);
                $tenant->tenantAttachmentFiles()->create([
                    'company_id' => Auth::user()->company_id,
                    'attachment_file_name' => $attachmentFileName,
                    'attachment_file' => $attachmentFilePath,
                ]);
            }
        }
        return redirect()->route('tenant.index', ['selectedTenantId' => $tenant->id]);
    }
    public function edit(Tenant $tenant)
    {
        $tenant = Tenant::where('id', $tenant->id)
            ->with('tenantAttachmentFiles')
            ->with('state')
            ->first();
        $states = State::all();
        $tenantTypes = TenantType::all();
        return Inertia('Tenant/Create', [
            'tenant' => $tenant,
            'states' => $states,
            'tenantTypes' => $tenantTypes
        ]);
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('tenant.index');
    }

    public function duplicate($id)
    {
        $original = Tenant::find($id);
        $duplicate = $original->replicate();
        $duplicate->save();

        return redirect()->route('tenant.index');
    }
}
