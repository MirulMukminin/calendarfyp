<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //Authenticate User Login Session
    public function authenticate(Request $request)
    {

        $request->request->remove('_token');
        //dd($request->all());
        //dd(auth()->attempt($request->all()));
        if (auth()->attempt($request->all())) {
            $request->session()->regenerate();

            if ($request->email == 'admin@test.com') {
                return redirect('/admin');
            }
            return redirect('/');
        } else {
            $user = DB::table('users')->where('email', $request->email)->exists();
            //dd($request->email);
            if ($user) {
                Session::flash('error_code', 3);
                return back();
            } else {
                Session::flash('error_code', 4);
                return back();
            }
        }
    }

    //Logout User from the System
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect('/login');
    }

    public function register()
    {
        return view('register');
    }

    public function create(Request $request)
    {
        if ($request->password == $request->password_confirmation) {
            $user_old = $request->all();
            $password = bcrypt($request->password);
            $user_old['password'] = $password;
            $user = User::create($user_old);

            auth()->login($user);

            return redirect('/');
        } else {
            return back();
        }
    }
}
