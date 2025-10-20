<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Mahasiswa;

class ProfileController extends Controller
{

    public function edit()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $user = Mahasiswa::find(Auth::id());
        $data = $request->all();

        $validator = Validator::make($data, [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tabel_mahasiswa,email,' . $user->id_mahasiswa . ',id_mahasiswa',
            'jurusan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $fotoPath = $request->file('foto')->store('profile', 'public');
            $user->foto = $fotoPath;
        }

        $user->nama = $data['nama'];
        $user->email = $data['email'];
        $user->jurusan = $data['jurusan'] ?? null;
        $user->alamat = $data['alamat'] ?? null;
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
