<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DraftInvoicesController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Invoices/DraftInvoices');
    }
}
