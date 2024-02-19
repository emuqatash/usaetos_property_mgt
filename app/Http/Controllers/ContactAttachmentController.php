<?php

namespace App\Http\Controllers;

use App\Models\ContactAttachmentFile;

class ContactAttachmentController extends Controller
{
    public function destroy(string $id): void
    {
        $contactAttachmentFile = ContactAttachmentFile::find($id);
        if ($contactAttachmentFile) {
            $contactAttachmentFile->delete();
        }
    }
}
