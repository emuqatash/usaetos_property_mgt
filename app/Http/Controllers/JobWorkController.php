<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobStoreRequest;
use App\Models\Contact;
use App\Models\JobWork;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class JobWorkController extends Controller
{
    public function index(Request $request)
    {
        return Inertia('JobWork/Index', [
            'job' => JobWork::query()
                ->with('contact')
                ->with('company')
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('job_number', 'like', "%{$search}%")
                        ->orWhereHas('contact', function ($query) use ($search) {
                            $query->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        })
                        ->orWhere('job_location', 'like', "%{$search}%");
                })
                ->when($request->input('jobStatus', 'New'), function ($query, $status) {
                    $query->where('job_status', $status);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->withQueryString()
                ->through(function ($job) {
                    // Retrieve salesmen names based on the salesman_ids JSON field
                    $salesmenNames = User::whereIn('id', $job->salesman_ids ?: [])
                        ->pluck('name')
                        ->toArray();
                    return [
                        'id' => $job->id,
                        'customer' => $job->contact->first_name.' '.$job->contact->last_name,
                        'user' => optional($job->user)->name, // Use optional() in case user relation is not loaded
                        'salesmen' => implode(', ', $salesmenNames),
                        'job_number' => $job->job_number,
                        'job_location' => Str::beforeLast(Str::after($job->job_location, ' '), ', USA'),
                    ];
                }),
            'filters' => $request->only(['search', 'jobStatus']),
        ]);
    }

    public function create()
    {
        $salesmen = User::whereHas('Role', function ($query) {
            $query->where('name', 'Sales');
        })->select('id', 'name')->get();
        $contactList = Contact::all();
        $insuranceAgentList = \DB::table('insurance_agents')->select('id', 'agent_name')->get();
        return Inertia('JobWork/Create', compact('salesmen', 'contactList', 'insuranceAgentList'));
    }

    public function store(JobStoreRequest $request)
    {
        $job = $request->all();

        if ($request->input('id') > 0) {
            $job = JobWork::find($request->input('id'));
        }else{
            $job['user_id'] = Auth::user()->id;
            $job['salesman_ids'] = $request->input('salesman_ids', []);
            $job['job_status'] = 'New';
            $job['company_id'] = Auth::user()->company_id;
            $job = JobWork::create($job);
            return redirect()->route('jobworks.index', $job);
        }

        if ($request->hasfile('permitFiles')) {
            foreach ($request->file('permitFiles') as $file) {
                $permitFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'.'.$file->getClientOriginalExtension();
                $permitFilePath = $file->storeAs('public/permit_files', $permitFileName);
                $job->jobPermitFiles()->create([
                    'company_id' => Auth::user()->company_id,
                    'permit_file_name' => $permitFileName,
                    'permit_file' => $permitFilePath,
                ]);
            }
        }

        if ($request->hasfile('attachmentFiles')) {
            foreach ($request->file('attachmentFiles') as $file) {
                $attachmentFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'.'.$file->getClientOriginalExtension();
                $attachmentFilePath = $file->storeAs('public/attachment_files', $attachmentFileName);
                $job->jobAttachmentFiles()->create([
                    'company_id' => Auth::user()->company_id,
                    'attachment_file_name' => $attachmentFileName,
                    'attachment_file' => $attachmentFilePath,
                ]);
            }
        }
        return redirect()->route('jobworks.show', $job);
    }

    public function show(JobWork $job)
    {
        $job->load('insuranceAgent','jobPermitFiles', 'jobAttachmentFiles', 'specification');
        $salesmen = User::whereHas('Role', function ($query) {
            $query->where('name', 'Sales');
        })->select('id', 'name')->get();
        $contact = Contact::where('id', $job->contact_id)->first();
        $selectedSalesmen = User::whereIn('id', $job->salesman_ids)->get();
        return Inertia('JobWork/Show', compact('job','contact','selectedSalesmen','salesmen'));
    }

    public function edit(JobWork $job)
    {
        $job->load('contact','insuranceAgent');
        $salesmen = User::whereHas('Role', function ($query) {
            $query->where('name', 'Sales');
        })->select('id', 'name')->get();
        $contactList = Contact::all();
        $insuranceAgentList = \DB::table('insurance_agents')->select('id', 'agent_name')->get();
        $selectedSalesmen = User::whereIn('id', $job->salesman_ids)->get();
        return Inertia('JobWork/Edit', compact('job','salesmen', 'contactList', 'insuranceAgentList','selectedSalesmen'));
    }

    public function update(Request $request, JobWork $job)
    {
        $input = $request->except('_token', 'id', '_method');
        $job->update($input);
        return redirect()->route('jobworks.show', $job);
    }

    public function destroy(JobWork $job)
    {
        $job->delete();
        return redirect()->route('jobworks.index');
    }
}
