<?php

namespace App\Http\Controllers;

use App\Models\SpecificationAttachmentFile;

class SpecificationAttachmentController extends Controller
{
    public function destroy(string $id)
    {
        $SpecificationAttachmentFile = SpecificationAttachmentFile::find($id);
        if ($SpecificationAttachmentFile) {
            $SpecificationAttachmentFile->delete();
        }
    }
}
