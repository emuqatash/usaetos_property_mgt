<?php

namespace App\Http\Controllers;

use App\Models\JobPermitFile;

class JobPermitFileController extends Controller
{
    public function destroy(string $id)
    {
        $jobPermitFile = JobPermitFile::find($id);
        if ($jobPermitFile) {
            $jobPermitFile->delete();
        }
    }
}
