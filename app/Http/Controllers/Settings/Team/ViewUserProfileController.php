<?php

namespace App\Http\Controllers\Settings\Team;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ViewUserProfileController extends Controller
{
    public function __invoke(User $user)
    {
        abort_if(! auth()->user()->isAdmin(), 403);

        return Inertia::render('Settings/Profile', [
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }
}
