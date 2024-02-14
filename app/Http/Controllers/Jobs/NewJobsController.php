<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class NewJobsController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Jobs/NewJobs');
    }
}
