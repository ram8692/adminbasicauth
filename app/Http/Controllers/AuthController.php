<?php

namespace App\Http\Controllers;

use App\Validators\AuthValidators;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
  protected $maxAttempts;
  protected $decayMinutes;

  public function __construct()
  {
    $this->middleware('guest')->except('logout');
    $this->maxAttempts = 5;
  }

  public function showLoginForm()
  {
    return view('auth.login');
  }

  public function login(Request $request)
  {
    $validator = AuthValidators::validate('login', $request->all());

    if ($validator->fails()) {
      return redirect()->route('login')->withErrors($validator)->withInput();
    }

    $errors = [];

    if ($this->hasTooManyLoginAttempts($request) || !$this->attemptLogin($request)) {
      $this->incrementLoginAttempts($request);

      // Check if throttling limit is exceeded
      if ($this->hasTooManyLoginAttempts($request)) {
        $throttleKey = $this->throttleKey($request);
        $seconds = RateLimiter::availableIn($throttleKey);

        $errors['throttle'] = trans('auth.throttle', ['seconds' => $seconds]);
      }

      $errors['email'] = trans('auth.failed');
    }

    if (!empty($errors)) {
      return redirect()->route('login')->withErrors($errors)->withInput();
    }

    return $this->sendLoginResponse($request);
  }

  protected function hasTooManyLoginAttempts(Request $request)
  {
    $throttleKey = $this->throttleKey($request);
    return RateLimiter::tooManyAttempts($throttleKey, $this->maxAttempts);
  }

  public function getMaxAttempts()
  {
    return $this->maxAttempts;
  }

  public function decayMinutes()
  {
    return property_exists($this, 'decayMinutes') ? $this->decayMinutes : 1;
  }

  protected function attemptLogin(Request $request)
  {
    return Auth::guard()->attempt(
      $request->only($this->username(), 'password'),
      $request->boolean('remember')
    );
  }

  public function username()
  {
    return 'email';
  }

  protected function incrementLoginAttempts(Request $request)
  {
    $throttleKey = $this->throttleKey($request);

    // Specify the rate limiting rules (5 attempts per 1 hour)
    $maxAttempts = 5;
    $decayMinutes = 60;

    // Use the RateLimiter instance to hit the rate limit
    RateLimiter::hit($throttleKey, $decayMinutes * 60, $maxAttempts);
  }

  protected function sendLoginResponse(Request $request)
  {
    $request->session()->regenerate();

    $this->clearLoginAttempts($request);

    // Customize the route you want to redirect to after a successful login
    return redirect()->route('users.index'); // Replace 'users.index' with your desired route
  }

  protected function throttleKey(Request $request)
  {
    return Str::transliterate(Str::lower($request->input($this->username())) . '|' . $request->ip());
  }

  protected function clearLoginAttempts(Request $request)
  {
    $throttleKey = $this->throttleKey($request);

    // Use the RateLimiter instance to clear the login attempts
    RateLimiter::clear($throttleKey);
  }

  public function logout(Request $request)
    {
      Auth::guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
