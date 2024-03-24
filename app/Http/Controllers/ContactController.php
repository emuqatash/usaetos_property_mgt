<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactType;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Cache::remember('articles', 60, function () use ($request) {
            return Contact::query()
                ->with('contactType')
                ->with('state')
                ->with('company')
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                })
                ->orderBy('first_name')
                ->paginate(10)
                ->withQueryString()
                ->through(fn($contact) => [
                    'id' => $contact->id,
                    'first_name' => $contact->first_name,
                    'last_name' => $contact->last_name,
                    'contact_type_name' => $contact->contactType->name,
                    'phone_number_1' => $contact->phone_number_1,
                    'phone_number_2' => $contact->phone_number_2,
                    'email' => $contact->email,
                    'address' => $contact->address,
                    'city' => $contact->city,
                    'state_name' => optional($contact->state)->name,
                    'zip' => $contact->zip,
                    'document_id' => $contact->document_id,
                    'company_name' => $contact->company->name,
                    'profile_photo_path' => $contact->profile_photo_path,
                    'remarks' => $contact->remarks,
                ]);
        });

        return Inertia('Contact/Index', [
            'contact' => $contacts,
            'filters' => $request->only(['search']),
            'selectedContactId' => (int)$request->input('selectedContactId'),
        ]);
    }

    // Returns all 500 without Caching
//    public function allWithoutCache()
//    {
//        return Contact::all();
//    }

    public function create()
    {
        $states = State::all();
        $contactTypes = ContactType::all();
        return Inertia('Contact/Create', compact('states', 'contactTypes'));
    }

    public function store(StoreContactRequest $request)
    {
        $contact = $request->all();
        if ($request->input('id') > 0) {
            $contact_data = $request->all();
            $contact = Contact::find($request->input('id'));
            $contact->update($contact_data);
        } else {
            $contact['company_id'] = Auth::user()->company_id;
            $contact = Contact::create($contact);
        }

        if ($request->hasfile('attachmentFiles')) {
            $userId = Auth::user()->id;
            $contactId = $contact->id;
            $companyId = Auth::user()->company_id;
            foreach ($request->file('attachmentFiles') as $file) {
                $attachmentFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $file->getClientOriginalExtension();
                $attachmentFilePath = $file->storeAs('public/contact_attachment_files/'.$companyId .'/'. $userId . '/' . $contactId, $attachmentFileName);
                $contact->contactAttachmentFiles()->create([
                    'company_id' => Auth::user()->company_id,
                    'attachment_file_name' => $attachmentFileName,
                    'attachment_file' => $attachmentFilePath,
                ]);
            }
        }
        return redirect()->route('contacts.index', ['selectedContactId' => $contact->id]);
    }

    public function edit(Contact $contact)
    {
        $contact = Contact::where('id', $contact->id)
            ->with('contactAttachmentFiles')
            ->with('state')
            ->first();
        $states = State::all();
        $contactTypes = ContactType::all();
        return Inertia('Contact/Create', [
            'contact' => $contact,
            'states' => $states,
            'contactTypes' => $contactTypes
        ]);
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
}
