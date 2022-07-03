<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  use AuthenticatesUsers {
    logout as performLogout;
  }

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  protected function credentials(Request $request)
  {

    if (filter_var(request('email'), FILTER_VALIDATE_EMAIL)) {
      return $request->only($this->username(), 'password');
    } else {
      return ['username' => $request->get('email'), 'password' => $request->get('password')];
    }

    // return $request->only($this->username(), 'password');
  }

  public function logout(Request $request)
  {
    $this->performLogout($request);
    return redirect()->route('management.showLoginForm');
  }
}