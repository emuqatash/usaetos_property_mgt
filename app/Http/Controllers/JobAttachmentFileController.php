<?php

namespace App\Http\Controllers;

use App\Models\JobAttachmentFile;

class JobAttachmentFileController extends Controller
{
    public function destroy(string $id)
    {
        $jobAttachmentFile = JobAttachmentFile::find($id);
        if ($jobAttachmentFile) {
            $jobAttachmentFile->delete();
        }
    }
}
