<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Update the user's profile picture.
     */
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        // Delete the old profile image if it exists and is not the default
        if ($user->profile_image && $user->profile_image !== 'images/default-profile.png') {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Store the new profile image
        $path = $request->file('profile_image')->store('profile-images', 'public');

        // Update the user's profile image path
        $user->update([
            'profile_image' => $path,
        ]);

        return redirect()->back()->with('status', 'Photo de profil mise à jour avec succès!');
    }
}
