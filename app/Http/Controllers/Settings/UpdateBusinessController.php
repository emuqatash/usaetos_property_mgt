<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateBusinessRequest;
use App\Models\Company;

class UpdateBusinessController extends Controller
{
    public function __invoke(UpdateBusinessRequest $request)
    {
        // TODO: Add validation for who can update a company
        abort_if($request->input('company_id') !== auth()->user()->company_id, 403);

        $company = Company::findOrFail($request->input('company_id'));

        $company->update([
            $request->input('field') => $request->input('value'),
        ]);
    }
}
