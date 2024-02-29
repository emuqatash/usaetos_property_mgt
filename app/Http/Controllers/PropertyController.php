<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyRequest;
use App\Models\Property;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        return Inertia('Property/Index', [
            'property' => Property::query()
                ->with('state')
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('property_no', 'like', "%{$search}%")
                        ->orWhere('property_name', 'like', "%{$search}%")
                        ->orWhere('owner', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        // Add this line to search in the related state's name.
                        ->orWhereHas('state', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                })
                ->orderBy('created_at', 'desc')
                ->paginate(6)
                ->withQueryString()
                ->through(function ($property) {
                    return [
                        'id' => $property->id,
                        'property_no' => $property->property_no,
                        'property_name' => $property->property_name,
                        'owner' => $property->owner,
                        'state_name' => $property->state->name,
                        'ownership_rate' => $property->ownership_rate,
                        'cost' => $property->cost,
                    ];
                }),
            'filters' => $request->only(['search', 'propertyStatus']),
        ]);
        // Respond with JSON.
    }

    public function create()
    {
        $states = State::all();
        return Inertia('Property/Create',compact('states'));
    }

    public function store(PropertyRequest $request)
    {
        $property = $request->all();
        if ($request->input('id') > 0) {
            $property_data = $request->all();
            $property = Property::find($request->input('id'));
            $property->update($property_data);
        } else {
            $property['company_id'] = Auth::user()->company_id;
            $property = Property::create($property);
        }

        return redirect()->route('property.index', $property);
    }

    public function show(Property $property)
    {
        $states = State::all();
        $property->load('state');
        return Inertia('Property/Create', compact('property', 'states'));
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('property.index');
    }
}
