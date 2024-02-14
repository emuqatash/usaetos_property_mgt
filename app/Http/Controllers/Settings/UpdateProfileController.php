<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateProfileController extends Controller
{
    public function __invoke(UpdateProfileRequest $request)
    {
        abort_if(! auth()->user()->isAdmin() && $request->input('user_id') !== auth()->id(), 403);

        $user = User::findOrFail($request->input('user_id'));

        $value = $request->input('value');

        if ($request->input('field') === 'password') {
            $value = Hash::make($request->input('value'));
        }

        $user->update([
            $request->input('field') => $value,
        ]);
    }
}
