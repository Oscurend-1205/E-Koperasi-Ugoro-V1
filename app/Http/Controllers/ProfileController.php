<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('user.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        if (!empty($validated['profile_photo_base64'])) {
            $image_parts = explode(";base64,", $validated['profile_photo_base64']);
            if (count($image_parts) == 2) {
                if ($request->user()->profile_photo) {
                    Storage::disk('public')->delete($request->user()->profile_photo);
                }
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = uniqid() . '.jpg';
                $filePath = 'profile-photos/' . $fileName;
                Storage::disk('public')->put($filePath, $image_base64);
                $validated['profile_photo'] = $filePath;
            }
            unset($validated['profile_photo_base64']);
        }

        // Secure the 'name' update logic
        if (!($request->user()->isAdmin() || session()->has('admin_impersonate'))) {
            unset($validated['name']);
        }

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
