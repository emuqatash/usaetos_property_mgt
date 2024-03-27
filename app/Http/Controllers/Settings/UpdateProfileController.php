<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UpdateProfileController extends Controller
{
    public function __invoke(UpdateProfileRequest $request)
    {
//        dd($request);
        abort_if(! auth()->user()->isAdmin() && $request->input('user_id') !== auth()->id(), 403);

        $user = User::findOrFail($request->input('user_id'));
        $value = $request->input('value');

        // if role field is provided in the request
            if ($request->input('field') === 'role_id') {
            $user->roles()->detach();   // Remove any previous roles from this user
            $role = Role::findById($request->input('value'));  // Assign a new role to the user
            $user->assignRole($role);
        }

        if ($request->input('field') === 'password') {
            $value = Hash::make($request->input('value'));
        }

        $user->update([
            $request->input('field') => $value,
        ]);

    }
}
