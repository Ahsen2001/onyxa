<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'admin' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $admin = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($admin->id)],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $admin->name = $data['name'];
        $admin->email = $data['email'];

        if (! empty($data['password'])) {
            if (! Hash::check((string) $data['current_password'], $admin->password)) {
                return back()
                    ->withInput($request->except(['password', 'password_confirmation', 'current_password']))
                    ->with('error', 'The current password is incorrect.');
            }

            $admin->password = Hash::make($data['password']);
        }

        $admin->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
