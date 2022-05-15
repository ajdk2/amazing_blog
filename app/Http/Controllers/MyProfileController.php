<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MyProfileController extends Controller
{
    public function edit()
    {
        $breadcrumbs = [];

        $breadcrumbs[] = [
            'title' => 'My Profile',
            'url' => '',
        ];

        return view('admin.my-profile.edit', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'My Profile',
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = User::find(auth()->id());

        $validated = $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => [
                Rule::unique('users')->ignore($user->id),
                'email'
            ],
            'password' => 'nullable',
            'password_confirmation ' => 'nullable|confirmed',
        ]);

        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];

        if (isset($validated['password'])) {
            $user->password =  bcrypt($validated['password']);
            $user->save();

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
        }

        $user->save();

        return redirect(route('admin.post.index'))->with('status', 'My Profile updated!');
    }
}
