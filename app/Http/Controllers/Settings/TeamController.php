<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class TeamController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Settings/Team', [
            'users' => auth()->user()->company->users()->with('role')->get(),
            'roles' => [],
        ]);
    }
}
