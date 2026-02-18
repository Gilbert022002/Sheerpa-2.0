<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->route('verification.notice')
                    ->with('message', 'Veuillez vérifier votre adresse email avant de vous connecter.');
            }
            
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            if ($user->role === 'instructor') {
                return redirect()->intended('/instructor/dashboard');
            }

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos dossiers.',
        ])->onlyInput('email');
    }

    /**
     * Display the registration form.
     */
    public function showRegistrationForm()
    {
        // We need to create this view
        return view('register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in(['user', 'instructor'])],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ];

        if ($request->role === 'instructor') {
            $data['instructor_status'] = 'pending';
        }

        $user = User::create($data);

        // Send verification email manually
        $user->sendEmailVerificationNotification();

        // Log the user in (they can access limited features until verified)
        Auth::login($user);

        // Redirect to verification notice page
        return redirect()->route('verification.notice')
            ->with('message', 'Un email de vérification a été envoyé à votre adresse email.');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
