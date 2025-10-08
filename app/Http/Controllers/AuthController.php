<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    // ... (showLogin & showRegister methods) ...
    public function showLogin()
    {
        return view('Auth.login'); // sesuaikan dengan view AdminLTE
    }
    public function showRegister()
    {
        return view('Auth.regis'); // sesuaikan dengan view AdminLTE
    }
    public function register(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:70',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:8',
            ],
            ['name.required' => 'Masukkan email terlebih dahulu', 'name.max' => 'Nama yang anda masukkan melebihi batas maksimal', 'email.required' => 'Masukkan email terlebih dahulu', 'email.max' => 'Email anda melebihi batas maksimal', 'email.unique' => 'Sorry bro, email lu udah ada', 'password.required' => 'Masukkan password anda terlebih dahulu', 'password.confirmed' => 'Password anda tidak sesuai', 'password.min' => 'Minimal Password 8'],
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Masukkan email terlebih dahulu',
                'email.email' => 'Harus berupa email yang valid',
                'password.required' => 'Masukkan password anda terlebih dahulu',
            ],
        );

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'Maaf, email ini tidak terdaftar.'])
                ->withInput(['email']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['password' => 'Maaf, password yang Anda masukkan salah.'])
                ->withInput(['email']);
        }
        Auth::login($user, $request->filled('remember'));

        $request->session()->regenerate();
        if ($user->hasRole('superadmin')) {
            return redirect()->route('users.index');
        }

        $allRoles = Role::pluck('name')->toArray();

        if ($user->hasAnyRole($allRoles)) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('dashboard')->with('error', 'Maaf anda tidak memiliki akses role');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
