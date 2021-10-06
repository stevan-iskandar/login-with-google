<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|min:6',
        ]);

        $dataUser = User::where(DB::raw('BINARY `email`'), $request->email)->first();

        if (!$dataUser)
        return redirect()->back()->with('icon', 'danger')->with('message', 'User not found')->withInput($request->only('email'));

        if (!Hash::check($request->password, $dataUser->password))
        return redirect()->back()->with('icon', 'danger')->with('message', 'Wrong password')->withInput($request->only('email'));

        Auth::login($dataUser);
        return redirect(route('home'))->with('icon', 'success')->with('message', 'Login success');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }

    public function redirect($type)
    {
        return Socialite::driver($type)->redirect();
    }

    public function callback($type)
    {
        try {
            $socialiteUser  = Socialite::driver($type)->user();
            $user           = User::where("{$type}_id", $socialiteUser->id)->first();

            if (!$user) {
                $user = User::create([
                    'name'          => $socialiteUser->name,
                    'email'         => $socialiteUser->email,
                    "{$type}_id"    => $socialiteUser->id,
                    'password'      => Hash::make('123456dummy'),
                ]);
            }

            Auth::login($user);
            return redirect(route('home'));
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
