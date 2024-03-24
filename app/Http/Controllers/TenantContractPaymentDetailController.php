<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\TenantContractPaymentDetail;
use Illuminate\Http\Request;

class TenantContractPaymentDetailController extends Controller
{
    public function destroy(string $id): void
    {
        $contactContractPaymentDetail = TenantContractPaymentDetail::find($id);
        if ($contactContractPaymentDetail) {
            $contactContractPaymentDetail->delete();
        }
    }
}
