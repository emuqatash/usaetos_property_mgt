<?php

namespace App\Http\Controllers;

use App\Models\SpecificationAttachmentFile;

class SpecificationAttachmentController extends Controller
{
    public function destroy(string $id): void
    {
        $specificationAttachmentFile = SpecificationAttachmentFile::find($id);
        if ($specificationAttachmentFile) {
            $specificationAttachmentFile->delete();
        }
    }
}
