<?php

namespace App\Http\Controllers;

use App\Models\PropertyExpenseAttachmentFile;

class PropertyExpenseAttachmentController extends Controller
{
    public function destroy(string $id): void
    {
        $propertyExpenseAttachmentFile = PropertyExpenseAttachmentFile::find($id);
        if ($propertyExpenseAttachmentFile) {
            $propertyExpenseAttachmentFile->delete();
        }
    }
}
