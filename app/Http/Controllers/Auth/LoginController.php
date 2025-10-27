<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // ✅ ADD THIS
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // If user is admin
        if ($user->email === env('ADMIN_EMAIL') && $request->password === env('ADMIN_PASSWORD')) {
            return redirect('/admin/dashboard'); // redirect admin
        }

        // Normal users
        return redirect('/home');
    }
}
