<?php

namespace App\Http\Controllers;

use App\Helpers\ActiveTenant;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\TenantType;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTenantRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->has('active')) {
            $request->request->add(['active' => '1']);
        }

        $tenants = Cache::remember('articles', 60, function () use ($request) {
            return Tenant::query()
                ->with('tenantType', 'tenantContracts', 'property', 'company')
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('phone_number_1', 'like', "%{$search}%");
                })
                ->when($request->input('selectedTenantId'), function ($query, $selectedTenantId) {
                    $query->where('id', $selectedTenantId);
                })
                ->when($request->input('contractStatus') === 'expired_contracts', function ($query) {
                    return ActiveTenant::active($query)
                        ->whereRaw('tenants.id IN (SELECT t.id FROM tenants t LEFT JOIN (SELECT tenant_id, MAX(end_date)
                    AS end_date FROM tenant_contracts GROUP BY tenant_id) tc
                    ON t.id = tc.tenant_id WHERE tc.end_date < CURRENT_DATE)');
                })
                ->when($request->input('contractStatus') === 'expired_contracts_30_days', function ($query) {
                    return ActiveTenant::active($query)
                        ->whereRaw('tenants.id IN (SELECT t.id FROM tenants t LEFT JOIN (SELECT tenant_id, MAX(end_date)
                    AS end_date FROM tenant_contracts GROUP BY tenant_id) tc
                    ON t.id = tc.tenant_id
                    WHERE tc.end_date >= CURRENT_DATE AND tc.end_date <= DATE_ADD(CURRENT_DATE, INTERVAL 30 DAY))');
                })
                ->when($request->input('contractStatus') === 'expired_contracts_60_days', function ($query) {
                    return ActiveTenant::active($query)
                        ->whereRaw('tenants.id IN (SELECT t.id FROM tenants t LEFT JOIN (SELECT tenant_id, MAX(end_date)
                    AS end_date FROM tenant_contracts GROUP BY tenant_id) tc
                    ON t.id = tc.tenant_id
                    WHERE tc.end_date > DATE_ADD(CURRENT_DATE, INTERVAL 30 DAY) AND tc.end_date <= DATE_ADD(CURRENT_DATE, INTERVAL 60 DAY))');
                })
                ->when($request->input('contractStatus') === 'expired_contracts_90_days', function ($query) {
                    return ActiveTenant::active($query)
                        ->whereRaw('tenants.id IN (SELECT t.id FROM tenants t LEFT JOIN (SELECT tenant_id, MAX(end_date)
                    AS end_date FROM tenant_contracts GROUP BY tenant_id) tc
                    ON t.id = tc.tenant_id
                    WHERE tc.end_date > DATE_ADD(CURRENT_DATE, INTERVAL 60 DAY) AND tc.end_date <= DATE_ADD(CURRENT_DATE, INTERVAL 90 DAY))');
                })
                ->when($request->input('active'), function ($query, $active) {
                    $query->where('active', '=', $active);
                })
                ->orderBy('first_name')
                ->paginate(10)
                ->withQueryString()
                ->through(fn($tenant) => [
                    'id' => $tenant->id,
                    'first_name' => $tenant->first_name,
                    'last_name' => $tenant->last_name,
                    'latest_end_date' => optional($tenant->tenantContracts->sortByDesc('end_date')->first())->end_date,
                    'phone_number_1' => $tenant->phone_number_1,
                    'property_id' => optional($tenant->tenantContracts->sortByDesc('end_date')->first())->property_id,
                    'property_no' => Property::where('id',optional($tenant->tenantContracts->sortByDesc('end_date')
                        ->first())->property_id)->value('property_no'),
                ]);
        });

        return Inertia('Tenant/Index', [
            'tenant' => $tenants,
            'filters' => $request->only(['search','contractStatus','selectedTenantId','active']),
            'selectedTenantId' => (int)$request->input('selectedTenantId'),
            'counts' => [
                'expired_contracts' => (DB::selectOne('SELECT COUNT(*) as count FROM tenants t LEFT JOIN
                (SELECT tenant_id,MAX(end_date) AS end_date FROM tenant_contracts
                GROUP BY tenant_id) tc ON t.id = tc.tenant_id
                WHERE tc.end_date < CURRENT_DATE AND t.active = 1'))->count,

                'expired_contracts_30_days' => (DB::selectOne('SELECT COUNT(*) as count FROM tenants t LEFT JOIN
                (SELECT tenant_id,MAX(end_date) AS end_date FROM tenant_contracts
                GROUP BY tenant_id) tc ON t.id = tc.tenant_id
                WHERE tc.end_date >= CURRENT_DATE AND tc.end_date <= DATE_ADD(CURRENT_DATE, INTERVAL 30 DAY) AND t.active = 1'))->count,

                'expired_contracts_60_days' => (DB::selectOne('SELECT COUNT(*) as count FROM tenants t LEFT JOIN
                (SELECT tenant_id,MAX(end_date) AS end_date FROM tenant_contracts
                GROUP BY tenant_id) tc ON t.id = tc.tenant_id
                WHERE tc.end_date > DATE_ADD(CURRENT_DATE, INTERVAL 30 DAY) AND tc.end_date <= DATE_ADD(CURRENT_DATE, INTERVAL 60 DAY) AND t.active = 1'))->count,

                'expired_contracts_90_days' => (DB::selectOne('SELECT COUNT(*) as count FROM tenants t LEFT JOIN
                (SELECT tenant_id,MAX(end_date) AS end_date FROM tenant_contracts
                GROUP BY tenant_id) tc ON t.id = tc.tenant_id
                WHERE tc.end_date > DATE_ADD(CURRENT_DATE, INTERVAL 60 DAY) AND tc.end_date <= DATE_ADD(CURRENT_DATE, INTERVAL 90 DAY) AND t.active = 1'))->count,

                'expired_contracts_2month' => Tenant::whereHas('TenantContracts', function ($query) {
                    $query->where('end_date', '<', now()->subDays(60));
                })->count(),
                'inactive' => Tenant::where('active', 0)->count(),
                'active' => Tenant::where('active', 1)->count(),
            ]
        ]);
    }

    //Returns all 500 without Caching
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
            $tenant['country_id'] = Auth::user()->country_id;
            $tenant = Tenant::create($tenant);
        }

        if ($request->hasfile('attachmentFiles')) {
            $userId = Auth::user()->id;
            $tenantId = $tenant->id;
            $companyId = Auth::user()->company_id;
            foreach ($request->file('attachmentFiles') as $file) {
                $attachmentFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $file->getClientOriginalExtension();
                $attachmentFilePath = $file->storeAs('public/tenant_attachment_files/'.$companyId .'/'. $userId . '/' . $tenantId, $attachmentFileName);
                $tenant->tenantAttachmentFiles()->create([
                    'company_id' => Auth::user()->company_id,
                    'attachment_file_name' => $attachmentFileName,
                    'attachment_file' => $attachmentFilePath,
                ]);
            }
        }

        $tenant->load('tenantContracts');
        foreach ($tenant->tenantContracts as $tenantContract) {
            $tenantContract->active = $tenant->active;
            $tenantContract->save();
        }

        return redirect()->route('tenant.index', ['selectedTenantId' => $tenant->id]);
    }
    public function edit(Tenant $tenant)
    {
        $tenant = Tenant::where('id', $tenant->id)
            ->with('tenantAttachmentFiles')
            ->first();
        $tenantTypes = TenantType::all();
        return Inertia('Tenant/Create', [
            'tenant' => $tenant,
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
