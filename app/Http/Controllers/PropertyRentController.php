<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRentRequest;
use App\Models\Property;
use App\Models\PropertyRent;
use App\Models\TenantContract;
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
            ->orderBy('payment_date')
            ->paginate(5)
            ->withQueryString()
            ->through(fn($propertyRent) => [
                'id' => $propertyRent->id,
                'payment_amount' => $propertyRent->payment_amount,
                'payment_date' => $propertyRent->payment_date,
            ]);

        $property = Property::find($propertyId);
        return Inertia('PropertyRent/Show', compact('property', 'propertyRents'));
    }

    public function createPropertyRent($property_id)
    {
        $propertyRent = PropertyRent::all()->toArray();
        $monthlyRent = TenantContract::where('property_id', $property_id)->latest()->value('monthly_rent');
        return Inertia('PropertyRent/Edit',
            ['propertyRent' => $propertyRent, 'property_id' => $property_id, 'monthlyRent' => $monthlyRent]);
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
        return Inertia('PropertyRent/Edit',['propertyRents' => $propertyRents,'propertyRent_id' => $propertyRent_id]);
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
