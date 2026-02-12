<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Only allow admin to access this dashboard
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard');
        }

        $pendingInstructors = User::where('role', 'instructor')
                                ->where('instructor_status', 'pending')
                                ->get();
        
        return view('admin.dashboard', compact('pendingInstructors'));
    }

    public function approveInstructor(User $instructor)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
        }

        if ($instructor->role === 'instructor' && $instructor->instructor_status === 'pending') {
            $instructor->instructor_status = 'approved';
            $instructor->save();
            return back()->with('status', 'Instructor approved successfully.');
        }

        return back()->with('error', 'Could not approve instructor.');
    }

    public function rejectInstructor(User $instructor)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
        }

        if ($instructor->role === 'instructor' && $instructor->instructor_status === 'pending') {
            $instructor->instructor_status = 'rejected';
            $instructor->save();
            return back()->with('status', 'Instructor rejected successfully.');
        }

        return back()->with('error', 'Could not reject instructor.');
    }
}
