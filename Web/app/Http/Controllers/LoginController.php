<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use \Exception; // Make sure Exception is imported

class LoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            // Find user by email or create a new user
            $findUser = User::where('email', $user->email)->first();

            if ($findUser) {
                // Log in the existing user
                Auth::login($findUser);
                return redirect('/');

            } else {
                // Create and log in the new user
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => bcrypt('DummyPassword') // You might want to use a more secure method or generate a unique password
                ]);

                Auth::login($newUser);
            }

            // Redirect to home or the intended page
            return redirect('/');

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Google login error: ' . $e->getMessage());

            // Redirect with an error message
            return redirect('/login')->withErrors(['msg' => 'Unable to login, please try again.']);
        }
    }
}
