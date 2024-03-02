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
                ->when($request->input('propertyStatus'), function ($query, $status) {
                    $query->where('property_status', $status);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->withQueryString()
                ->through(function ($property) {
                    return [
                        'id' => $property->id,
                        'property_no' => $property->property_no,
                        'property_name' => $property->property_name,
                        'owner' => $property->owner,
                        'state_name' => $property->state->name,
                        'city' => $property->city,
                    ];
                }),
            'filters' => $request->only(['search', 'propertyStatus']),
            'counts' => [
                'vacant' => Property::where('property_status', 'Vacant')->count(),
                'occupied' => Property::where('property_status', 'Occupied')->count(),
            ],
        ]);
    }

    public function create()
    {
        $states = State::all();
        return Inertia('Property/Create',compact('states'));
    }

    public function store(PropertyRequest $request)
    {
        $property = $request->all();
//        dd( $property );
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

    public function duplicate($id)
    {
        $original = Property::find($id);
        $duplicate = $original->replicate();
        $duplicate->save();

        return redirect()->route('property.index');
    }
}
