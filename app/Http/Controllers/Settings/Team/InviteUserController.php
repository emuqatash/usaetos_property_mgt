<?php

namespace App\Http\Controllers\Settings\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\InviteUserRequest;
use App\Mail\Settings\InviteUserMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InviteUserController extends Controller
{
    public function __invoke(InviteUserRequest $request)
    {
        $password = Str::random(16);
        $newUser = User::create([
            'name' => $request->email,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role_id' => $request->role,
            'company_id' => auth()->user()->company_id,
        ]);

        Mail::to($newUser->email)->send(new InviteUserMail($newUser, $password));
    }
}
