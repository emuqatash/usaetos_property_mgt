<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BusinessController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Settings/Business', [
            'user' => Auth::user(),
            'company' => Auth::user()->company,
        ]);
    }
}
