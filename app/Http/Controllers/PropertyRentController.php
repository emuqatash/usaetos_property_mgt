<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRentRequest;
use App\Models\Property;
use App\Models\PropertyRent;
use App\Models\TenantContract;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyRentController extends Controller
{
    public function show(Request $request, $propertyId)
    {
        $propertyRents = PropertyRent::query()
            ->with('property')
            ->where('property_id', $propertyId)
            ->when($request->input('search'), function ($query, $search) {
                $query
                    ->where('payment_date', 'like', "%{$search}%")
                    ->orWhere('payment_amount', 'like', "%{$search}%");
            })
            ->orderBy('payment_date','desc')
            ->paginate(10)
            ->withQueryString()
            ->through(fn($propertyRent) => [
                'id' => $propertyRent->id,
                'payment_amount' => $propertyRent->payment_amount,
                'payment_date' => Carbon::parse($propertyRent->payment_date)->format('d-M-Y'),
                'grace_period' => $propertyRent->grace_period,
                'late_fee' => $propertyRent->late_fee,
            ]);

        $property = Property::find($propertyId);
        return Inertia('PropertyRent/Show', compact('property', 'propertyRents'));
    }

    public function createPropertyRent(request $request, $property_id)
    {
        $payment_date = $request->input('payment_date');
        $rent_amount = TenantContract::where('property_id', $property_id)->orderBy('end_date', 'desc')->value('rent_amount');
        $payment_frequency = TenantContract::where('property_id', $property_id)->orderBy('end_date', 'desc')->value('payment_frequency');
        $grace_period = TenantContract::where('property_id', $property_id)->orderBy('end_date', 'desc')->value('grace_period');
        $gracePeriodPlusTwoDays = now()->endOfMonth()->addDays($grace_period + 2);
        $currentLateFee = TenantContract::where('property_id', $property_id)->latest()->orderBy('end_date', 'desc')->value('late_fee');
        $lateFee = 0;

        if ($payment_frequency === 'Monthly') {
            $payment_date = $payment_date ? Carbon::parse($payment_date)->format('m/d/Y') : Carbon::now()->format('m/d/Y');
            if (($payment_date && Carbon::parse($payment_date)->greaterThan($gracePeriodPlusTwoDays))) {
                $lateFee = TenantContract::where('property_id', $property_id)->orderBy('end_date', 'desc')->value('late_fee');
                $rent_amount += $lateFee;
            }
        }

        return Inertia('PropertyRent/Edit',
            [
                'property_id' => $property_id,
                'rent_amount' => $rent_amount,
                'grace_period' => $grace_period +2,
                'lateFee' => $lateFee,
                'currentLateFee' => $currentLateFee,
                'payment_date' => Carbon::parse($payment_date)
            ]);
    }

    public function store(StorePropertyRentRequest $request)
    {
        $propertyRent = $request->all();
        if ($request->input('id') > 0) {
            $propertyRent_data = $request->all();
            $propertyRent = PropertyRent::find($request->input('id'));
            $propertyRent->update($propertyRent_data);
        } else {
            $propertyRent['company_id'] = Auth::user()->company_id;
            $propertyRent = PropertyRent::create($propertyRent);
        }

        return redirect()->route('property-rent.show', $propertyRent->property_id);
    }

    public function edit($propertyRent_id)
    {
        $propertyRents = PropertyRent::find($propertyRent_id);
        $currentLateFee = TenantContract::where('property_id', $propertyRents->property_id)->latest()->orderBy('end_date', 'desc')->value('late_fee');
        return Inertia('PropertyRent/Edit',['propertyRents' => $propertyRents,
            'propertyRent_id' => $propertyRent_id, 'currentLateFee' => $currentLateFee]);
    }

    public function destroy(PropertyRent $propertyRent)
    {
        $propertyRent->delete();
        return redirect()->route('property-rent.show', $propertyRent->property_id);
    }

    public function duplicate($id)
    {
        $original = PropertyRent::find($id);
        $duplicate = $original->replicate();
        $duplicate->save();
        return redirect()->route('property-rent.show', $original->property_id);
    }
}
