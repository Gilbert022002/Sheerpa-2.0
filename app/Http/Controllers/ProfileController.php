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

        // Store the new profile image in public/uploads for Hostinger compatibility
        $path = $request->file('profile_image')->store('uploads/profile-images', 'public');

        // Update the user's profile image path
        $user->update([
            'profile_image' => $path,
        ]);

        return redirect()->back()->with('status', 'Photo de profil mise à jour avec succès!');
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfileInfo(Request $request)
    {
        $user = Auth::user();
        
        // Define validation rules based on user role
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id() . ',id',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:100',
        ];

        // Add role-specific fields
        if ($user->role === 'instructor') {
            $rules['specialty'] = 'nullable|string|max:255';
            $rules['experience'] = 'nullable|string|max:100';
        } else {
            $rules['specialty'] = 'nullable|string|max:255';
        }

        $request->validate($rules);

        // Prepare update data
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
        ];

        // Add role-specific fields
        if ($user->role === 'instructor') {
            $updateData['specialty'] = $request->specialty;
            $updateData['experience'] = $request->experience;
        } else {
            $updateData['specialty'] = $request->specialty;
        }

        // Update the user's profile information
        $user->update($updateData);

        return redirect()->back()->with('status', 'Profil mis à jour avec succès!');
    }
}
