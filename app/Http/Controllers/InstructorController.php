<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function storeDetails(Request $request)
    {
        $request->validate([
            'experience' => ['required', 'string', 'min:50'],
            'stripe_account_id' => ['nullable', 'string', 'max:255'],
            'presentation_video_url' => ['nullable', 'url', 'max:255'],
        ]);

        $user = Auth::user();

        if ($user->role !== 'instructor') {
            return back()->withErrors('You are not an instructor.');
        }

        $user->update([
            'experience' => $request->experience,
            'stripe_account_id' => $request->stripe_account_id,
            'presentation_video_url' => $request->presentation_video_url,
            'instructor_status' => 'pending', // Re-set to pending on new submission
        ]);

        return redirect()->route('instructor.dashboard')->with('status', 'Your information has been submitted for review.');
    }
}
