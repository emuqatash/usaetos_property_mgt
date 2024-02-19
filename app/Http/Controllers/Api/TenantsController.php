<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class TenantsController extends Controller
{
    use GeneralTrait;
    public function getAllTenants()
    {
        $allTenants = Contact::get();
//        return response()->json($allTenants);
        return $this-> returnData('All Tenants', $allTenants);
    }

    public function getTenantById(Request $request)
    {
        $Tenant = Contact::find($request->id);
        if(!$Tenant){
           return $this->returnError('001', 'Tenant is not in database');
        }

        return  $this->returnSuccessMessage( 'Tenant retrieved successfully',  $Tenant);
    }

    public function changeTenantStatus(Request $request)
    {
        //validation
        Contact::where('id', $request->id)->update(['active' => $request->active]);
        return $this->returnSuccessMessage('Tenant status has been changed successfully');
    }

}
