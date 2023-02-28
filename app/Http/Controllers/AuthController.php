<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request -> validate([
			'name' => 'required',
			'password' => 'required'	
		]);
		if (Auth::attempt($credentials))
		{
			$request->session()->regenerate();
			return redirect()->intended('/');
			$request->session()->flash('LoginSucces','Login berhasil');
		}
		return back()->with('ErrorLogin','Login failed!');
    }

    public function index1(){
		return view('register/index', [
            'title' => 'register'
        ]);
	}
	public function signup(Request $request)
	{
		$validatedData = $request -> validate([
			'name'=> ['required','min:3','unique:users'],
			'email' =>'required|email|unique:users',
			'password'=>'required|min:3',
			
		]);
		$validatedData['password'] = Hash::make($validatedData['password']);
		User::create($validatedData);
		return redirect('/login')->with('success', 'Registrasi Berhasil');
	}

    public function logout (Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
