<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactType;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia('Contact/Index', [
            'contact' => Contact::query()
                ->with('contactType')
                ->with('state')
                ->with('company')
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                })
                ->orderBy('first_name')
                ->paginate(0)
                ->withQueryString()
                ->through(fn($contact) => [
                    'id' => $contact->id,
                    'first_name' => $contact->first_name,
                    'last_name' => $contact->last_name,
                    'contact_type_name' => $contact->contactType->name,
                    'phone_number' => $contact->phone_number,
                    'email' => $contact->email,
                    'address' => $contact->address,
                    'city' => $contact->city,
                    'state_name' => $contact->state->name,
                    'zip' => $contact->zip,
                    'company_name' => $contact->company->name,
                    'profile_photo_path' => $contact->profile_photo_path,
                ]),
            'filters' => $request->only(['search']),
            'selectedContactId' => (int) $request->input('selectedContactId'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = State::all();
        $contactTypes = ContactType::all();
        return Inertia('Contact/Create', compact('states', 'contactTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function validateRequest(StoreContactRequest $request)
    {
        $request->validated();
    }

    public function store(Request $request)
    {
        $validatedData = $request->all();
        if ($request->hasFile('image')) {
            $fileName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->storeAs('public/contact_images', $fileName);
            $validatedData['profile_photo_path'] = 'contact_images/'.$fileName;
        }
        if ($request->input('id') > 0) {
            $contact = Contact::find($request->input('id'));
            $contact->profile_photo_path = $validatedData['profile_photo_path'] ?? $contact->profile_photo_path;
            $contact->update($validatedData);
        } else {
            $validatedData['company_id'] = Auth::user()->company_id;
            $contact = Contact::create($validatedData);
        }
        return redirect()->route('contacts.index', ['selectedContactId' => $contact->id]);
    }

    public function show(Contact $contact)
    {
        $stateName = State::where('id', $contact->state_id)->value('name');
        $contactType = ContactType::where('id', $contact->contact_type_id)->value('name');
        return Inertia('Contact/Show', [
            'contact' => $contact,
            'stateName' => $stateName,
            'contactType' => $contactType,
        ]);
    }

    public function edit(Contact $contact)
    {
        $states = State::all();
        $contactTypes = ContactType::all();
        return Inertia('Contact/Edit', [
            'contact' => $contact,
            'states' => $states,
            'contactTypes' => $contactTypes,
        ]);
    }
}
