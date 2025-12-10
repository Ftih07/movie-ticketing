<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // <--- PENTING: Tambahkan ini

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:100',    
            'password' => 'nullable|confirmed|min:6',
            // Validasi gambar: harus gambar (jpg/png), max 2MB
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user->name = $data['name'];

        // 1. Cek apakah user mengupload file baru
        if ($request->hasFile('profile_image')) {
            // 2. Hapus gambar lama jika ada (biar server gak penuh)
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // 3. Simpan gambar baru ke folder 'profiles' di disk 'public'
            // Hasilnya path seperti: profiles/namafileacak.jpg
            $path = $request->file('profile_image')->store('profiles', 'public');

            // 4. Update path di database
            $user->profile_image = $path;
        }

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return back()->with('success', 'Profile updated.');
    }
}
