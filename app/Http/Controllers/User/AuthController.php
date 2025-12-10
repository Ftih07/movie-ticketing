<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // FORM LOGIN USER
    public function loginForm()
    {
        // Jika sudah login, redirect ke home
        if (Auth::check() && Auth::user()->role === 'customer') {
            return redirect()->route('user.movies.index');
        }

        return view('user.login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role !== 'customer') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Anda bukan customer.',
                ]);
            }

            return redirect()->route('movies.index');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function registerForm()
    {
        return view('user.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
        ]);

        auth()->login($user);

        return redirect()->route('movies.index');
    }

    // 1. Redirect user ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Handle balikan dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah ada (berdasarkan google_id atau email)
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            // LOGIKA DOWNLOAD FOTO
            // Kita ambil URL avatar dari Google
            $avatarUrl = $googleUser->getAvatar();
            $pathFoto = null;

            // Jika ada URL-nya, kita coba download
            if ($avatarUrl) {
                // 1. Ambil isi file dari URL Google
                $fileContents = file_get_contents($avatarUrl);

                // 2. Bikin nama file acak biar keren
                // Google biasanya JPG, jadi kita pakai .jpg agar valid. 
                // Kalau mau .webp harus pakai library converter, tapi .jpg sudah cukup oke.
                $filename = Str::random(40) . '.jpg';

                // 3. Simpan ke folder 'profiles' di disk public
                Storage::disk('public')->put('profiles/' . $filename, $fileContents);

                // 4. Set path yang akan masuk database
                $pathFoto = 'profiles/' . $filename;
            }

            if (!$user) {
                // --- KASUS USER BARU ---
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'role' => 'customer',
                    'password' => null,
                    'profile_image' => $pathFoto, // Masukkan path foto lokal
                ]);
            } else {
                // --- KASUS USER LAMA (Login Ulang / Link Akun) ---

                // Update google_id jika belum ada
                if (!$user->google_id) {
                    $user->google_id = $googleUser->getId();
                }

                // OPSI: Apakah mau update foto profil user dengan foto Google terbaru?
                // Jika user belum punya foto profil, kita pasang foto dari Google
                if (!$user->profile_image && $pathFoto) {
                    $user->profile_image = $pathFoto;
                }

                // Simpan perubahan
                $user->save();
            }

            Auth::login($user);

            return redirect()->route('movies.index');
        } catch (\Exception $e) {
            // Debugging: Uncomment baris bawah ini kalau mau liat pesan errornya
            // dd($e->getMessage());

            return redirect()->route('user.login')->withErrors(['email' => 'Login Google gagal, silakan coba lagi.']);
        }
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login');
    }
}
