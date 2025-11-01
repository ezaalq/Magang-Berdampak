<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            if (Auth::check()) {
                return redirect()->route('dashboard');
            }

            return view('Auth.login');
        }

        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $user = Mahasiswa::where('email', $credentials['email'])->first();

        if (! $user) {
            return back()->withErrors([
                'login_error' => 'Email tidak ditemukan',
            ])->withInput($request->only('email'));
        }

        // Verifikasi password
        if (! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'login_error' => 'Password salah',
            ])->withInput($request->only('email'));
        }

        // Login manual
        $remember = $request->has('remember-me');
        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function register(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('Auth.register');
        }

        $validator = Validator::make($request->all(), [
            'nim' => 'required|unique:tabel_mahasiswa,nim',
            'nama' => 'required',
            'email' => 'required|email|unique:tabel_mahasiswa,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'nim.required' => 'NIM wajib diisi',
            'nim.unique' => 'NIM sudah digunakan',
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login.');
    }

    public function changePassword(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('Auth.change-password');
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if (! Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        $user = Mahasiswa::find(Auth::id());
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Password berhasil diubah!');
    }

    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email',
            ]);
            $user = Mahasiswa::where('email', $request->email)->first();
            if ($user && $user->email) {
                $resetLink = route('resetPassword', ['email' => $user->email]);
                if ($user->email) {
                    Mail::to($user->email)->send(new ResetPasswordMail($resetLink));

                    return back()->with('success', 'Link reset password sudah dikirim ke email Anda.');
                } else {
                    return back()->with('success', 'Email tidak ditemukan. Link reset password: <a href="'.$resetLink.'">'.$resetLink.'</a>');
                }
            } else {
                return back()->withErrors(['email' => 'Email tidak ditemukan']);
            }
        }

        return view('Auth.forgot-password');
    }

    public function resetPassword(Request $request, $email)
    {
        $user = Mahasiswa::where('email', $email)->firstOrFail();
        if ($request->isMethod('get')) {
            return view('Auth.reset-password', compact('user'));
        }
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password berhasil direset!');
    }
}
