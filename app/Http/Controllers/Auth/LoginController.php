<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectTo)->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out!');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $this->handleSocialLogin($user, 'google');

            return redirect()->intended($this->redirectTo)->with('success', 'Login successful with Google!');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google login failed. Please try again.');
        }
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();

            $this->handleSocialLogin($user, 'facebook');

            return redirect()->intended($this->redirectTo)->with('success', 'Login successful with Facebook!');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Facebook login failed. Please try again.');
        }
    }

    /**
     * Handle social login logic.
     *
     * @param $socialUser
     * @param string $provider
     * @return void
     */
    protected function handleSocialLogin($socialUser, string $provider)
    {
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'password' => Hash::make(str_random(16)),
                'social_provider' => $provider,
                'social_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);
        } elseif (!$user->social_provider) {
            $user->update([
                'social_provider' => $provider,
                'social_id' => $socialUser->getId(),
            ]);
        }

        Auth::login($user);
    }
}
