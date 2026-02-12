<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Availability;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the instructor's availabilities.
     */
    public function index()
    {
        $availabilities = Auth::user()->availabilities()->get();
        return view('instructor.availabilities.index', compact('availabilities'));
    }

    /**
     * Store a newly created availability rule in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'day_of_week' => ['required', 'integer', 'min:0', 'max:6'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        Auth::user()->availabilities()->create($request->all());

        return redirect()->route('instructor.availabilities.index')->with('status', 'Availability rule created successfully!');
    }

    /**
     * Remove the specified availability rule from storage.
     */
    public function destroy(Availability $availability)
    {
        if ($availability->guide_id !== Auth::id()) {
            abort(403);
        }
        $availability->delete();
        return redirect()->route('instructor.availabilities.index')->with('status', 'Availability rule deleted successfully!');
    }
}
