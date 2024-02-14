<?php

namespace App\Http\Controllers\Contracts;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class PendingContractsController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Contracts/PendingContracts');
    }
}
