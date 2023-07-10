<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPasswordEmail;
use App\PasswordReset;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    //menampilkan halaman login
    public function login()
    {
        return view('login.index', [
            "title" => "Login"
        ]);
    }

    //proses autentikasi pengguna
    public function authenticate(Request $request)
    {
        $credentials = $request->validate(
            [
                'username' => 'required',
                'password' => 'required'
            ]
        );

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with(
            'loginError',
            'Maaf username atau password anda salah!'
        );
    }

    //logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }

    public function forget()
    {
        return view('login.forget', [
            'title' => 'Lupa Password'
        ]);
    }

    public function sendResetEmail(Request $request)
    {
        $validated_data = $request->validate([
            'username' => ['required', 'exists:tb_user,username']
        ]);

        $user = User::where('username', $validated_data['username'])->first();

        if ($user->password_reset()->exists()) {
            $user->password_reset()->delete();
        }

        $token = Str::random(32);
        while (PasswordReset::where('token', $token)->exists()) {
            $token = Str::random(32);
        }
        $expiry = Carbon::now()->addDay();

        $reset = new PasswordReset;
        $reset->token = $token;
        $reset->user()->associate($user);
        $reset->expired_at = $expiry;
        $reset->save();

        $url = env('APP_URL') . '/reset?token=' . $token;
        $email = $user->pegawai->email;
        Mail::to($email)->send(new ForgetPasswordEmail($user->name, $url));

        $redacted_email = substr($email, 0, 1) . '*****' . substr($email, strpos($email, '@') - 1);

        return view('login.success', [
            'title' => 'Sukses!',
            'message' => 'Silahkan cek ' . $redacted_email . ' untuk melakukan reset password.',
        ]);
    }

    public function reset(Request $request)
    {
        if (!$request->has('token')) {
            return redirect()->route('login');
        }

        $token = $request->query('token');
        $reset = PasswordReset::where('token', $token)->first();

        if (is_null($reset)) {
            return view('login.expired', [
                'title' => 'Mohon maaf :('
            ]);
        }

        if (Carbon::parse($reset->expired_at)->lessThan(Carbon::now())) {
            return view('login.expired', [
                'title' => 'Mohon maaf :('
            ]);
        }

        return view('login.reset', [
            'title' => 'Reset Password',
            'reset' => $reset
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validated_data = $request->validate([
            'token' => ['required', 'exists:tb_resetpassword,token'],
            'password' => ['required', 'confirmed']
        ]);

        $reset = PasswordReset::where('token', $validated_data['token'])->first();
        if (Carbon::parse($reset->expired_at)->lessThan(Carbon::now())) {
            return view('login.expired', [
                'title' => 'Mohon maaf :('
            ]);
        }

        $user = $reset->user;
        $user->password = bcrypt($validated_data['password']);
        $user->save();
        $user->password_reset()->delete();

        return view('login.success', [
            'title' => 'Sukses!',
            'message' => 'Password Anda berhasil direset. Silakan login untuk melanjutkan',
        ]);
    }
}
