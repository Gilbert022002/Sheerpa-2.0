<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Booking;
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

        // Stats
        $totalUsers = User::where('role', 'user')->count();
        $totalCourses = Course::count();
        $meetingsThisMonth = Booking::whereMonth('start_datetime', now()->month)
                                    ->whereYear('start_datetime', now()->year)
                                    ->count();
        $approvedInstructors = User::where('role', 'instructor')
                                   ->where('instructor_status', 'approved')
                                   ->count();

        // Recent courses
        $recentCourses = Course::with('guide')->latest()->limit(10)->get();

        return view('admin.dashboard', compact('pendingInstructors', 'totalUsers', 'totalCourses', 'meetingsThisMonth', 'approvedInstructors', 'recentCourses'));
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
