<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Controller for managing user profiles
 */
class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     */
    public function edit(): View
    {
        return view('profile');
    }

    /**
     * Update the profile in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        Log::info('ProfileController@update called', ['user_id' => Auth::id(), 'request' => $request->all()]);

        try {
            $user = Mahasiswa::findOrFail(Auth::id());

            $data = $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:tabel_mahasiswa,email,'.$user->id.',id',
                'jurusan' => 'nullable|string|max:255',
                'alamat' => 'nullable|string|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('foto')) {
                if ($user->foto && Storage::disk('public')->exists($user->foto)) {
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

            Log::info('Profile updated successfully', ['user_id' => $user->id]);

            return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
        } catch (ModelNotFoundException $e) {
            Log::warning('User not found for profile update', ['user_id' => Auth::id()]);

            return redirect()->route('profile.edit')->with('error', 'Pengguna tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error updating profile', ['user_id' => Auth::id(), 'error' => $e->getMessage(), 'request' => $request->all()]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil.')->withInput();
        }
    }
}
