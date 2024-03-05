<?php

namespace App\Http\Controllers;

use App\Models\TenantContractAttachmentFile;

class TenantContractAttachmentController extends Controller
{
    public function destroy(string $id): void
    {
        $contactContractAttachmentFile = TenantContractAttachmentFile::find($id);
        if ($contactContractAttachmentFile) {
            $contactContractAttachmentFile->delete();
        }
    }
}
