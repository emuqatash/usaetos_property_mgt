<?php

namespace App\Http\Controllers\Estimates;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DraftEstimatesController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Estimates/DraftEstimates');
    }
}
