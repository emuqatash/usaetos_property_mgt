<?php

namespace App\Http\Controllers;

use App\Models\TenantAttachmentFile;
class TenantAttachmentController extends Controller
{
    public function destroy(string $id): void
    {
        $contactAttachmentFile = TenantAttachmentFile::find($id);
        if ($contactAttachmentFile) {
            $contactAttachmentFile->delete();
        }
    }
}
