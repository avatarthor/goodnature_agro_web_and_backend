<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4|max:20',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $adminId = Auth::user();
            $request->session()->put('admin_id', $adminId->id);

            return redirect('admin')->with('success', 'Login Successful');
        }

        return redirect()->back()->withInput()->withErrors(['email' => 'Invalid login credentials.']);
    }

    // Your logout route or controller method
    public function logout(Request $request)
    {
            if ($request->session()->has('admin_id')) {
                Auth::guard('web')->logout();
                $request->session()->forget('admin_id');
                Session::flush();
                return redirect('/')->with('success', 'Logout Successful');
            }
    }

}
