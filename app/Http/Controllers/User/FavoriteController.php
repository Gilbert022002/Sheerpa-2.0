<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display the user's favorite courses.
     */
    public function index()
    {
        $favorites = Auth::user()->favoritedCourses()->with('guide')->latest()->get();
        
        return view('user.favorites.index', compact('favorites'));
    }

    /**
     * Toggle favorite status for a course.
     */
    public function toggle(Course $course)
    {
        $user = Auth::user();
        
        // Check if the course is already favorited
        $favorite = Favorite::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();
        
        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            $isFavorited = false;
        } else {
            // Add to favorites
            Favorite::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);
            $isFavorited = true;
        }
        
        // Return JSON response for AJAX requests
        return response()->json([
            'success' => true,
            'is_favorited' => $isFavorited,
            'message' => $isFavorited ? 'Course added to favorites' : 'Course removed from favorites',
        ]);
    }
}
