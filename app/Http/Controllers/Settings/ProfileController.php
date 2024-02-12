<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Settings/Profile', [
            'user' => Auth::user(),
            'roles' => Role::all(),
        ]);
    }
}
