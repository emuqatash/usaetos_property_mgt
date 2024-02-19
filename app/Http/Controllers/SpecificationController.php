<?php

namespace App\Http\Controllers;

use App\Models\Specification;
use Auth;
use Illuminate\Http\Request;

class SpecificationController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $jobId = $request->id;
        return Inertia('Specification/Create',['jobId' => $jobId]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        if ($request->input('id') > 0) {
            $specification = Specification::find($request->input('id'));
            $specification->update($input);
        } else{
            $input['company_id'] = Auth::user()->company_id;
            $specification = Specification::create($input );
        }

        if ($request->hasfile('attachmentFiles')) {
            foreach ($request->file('attachmentFiles') as $file) {
                $attachmentFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'.'.$file->getClientOriginalExtension();
                $attachmentFilePath = $file->storeAs('public/specification_files', $attachmentFileName);
                $specification->specificationAttachmentFiles()->create([
                    'company_id' => Auth::user()->company_id,
                    'attachment_file_name' => $attachmentFileName,
                    'attachment_file' => $attachmentFilePath,
                ]);
            }
        }

        return redirect()->route('jobs.show', $specification->job_id);
    }

    public function edit(Request $request)
    {
        $specification = Specification::where('job_id',$request->id)
            ->with('specificationAttachmentFiles')->first();
        $jobId = $request->id;
        return Inertia('Specification/Create', compact('specification', 'jobId'));
    }
}
