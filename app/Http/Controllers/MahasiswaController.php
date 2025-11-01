<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Controller for managing students (Mahasiswa)
 */
class MahasiswaController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(): View
    {
        $mahasiswa = Mahasiswa::all();

        return view('mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create(): View
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info('MahasiswaController@store called', ['request' => $request->except('password')]);

        try {
            $data = $request->validate([
                'nim' => 'required|string|max:20|unique:tabel_mahasiswa,nim',
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:tabel_mahasiswa,email',
                'asal_sekolah' => 'nullable|string|max:255',
                'jurusan' => 'nullable|string|max:255',
                'alamat' => 'nullable|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'password' => 'required|string|min:8',
                'role' => 'required|string|max:50',
            ]);

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('foto_mahasiswa', 'public');
            }

            $data['password'] = Hash::make($data['password']);
            Mahasiswa::create($data);
            Log::info('Student created successfully', ['nim' => $data['nim'], 'nama' => $data['nama']]);

            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating student', ['error' => $e->getMessage(), 'request' => $request->except('password')]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan mahasiswa.')->withInput();
        }
    }

    /**
     * Display the specified student.
     */
    public function show(int $id): View
    {
        try {
            $mhs = Mahasiswa::findOrFail($id);

            return view('mahasiswa.show', compact('mhs'));
        } catch (ModelNotFoundException $e) {
            Log::warning('Student not found', ['id' => $id]);
            abort(404, 'Mahasiswa tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(int $id): View
    {
        try {
            $mhs = Mahasiswa::findOrFail($id);

            return view('mahasiswa.edit', compact('mhs'));
        } catch (ModelNotFoundException $e) {
            Log::warning('Student not found for editing', ['id' => $id]);
            abort(404, 'Mahasiswa tidak ditemukan.');
        }
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        Log::info('MahasiswaController@update called', ['id' => $id, 'request' => $request->except('password')]);

        try {
            $mhs = Mahasiswa::findOrFail($id);
            $data = $request->validate([
                'nim' => 'required|string|max:20|unique:tabel_mahasiswa,nim,'.$id.',id',
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:tabel_mahasiswa,email,'.$id.',id',
                'asal_sekolah' => 'nullable|string|max:255',
                'jurusan' => 'nullable|string|max:255',
                'alamat' => 'nullable|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'password' => 'nullable|string|min:8',
                'role' => 'required|string|max:50',
            ]);

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('foto_mahasiswa', 'public');
            }

            if (! empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $mhs->update($data);
            Log::info('Student updated successfully', ['id' => $id]);

            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diupdate.');
        } catch (ModelNotFoundException $e) {
            Log::warning('Student not found for update', ['id' => $id]);

            return redirect()->route('mahasiswa.index')->with('error', 'Mahasiswa tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error updating student', ['id' => $id, 'error' => $e->getMessage(), 'request' => $request->except('password')]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate mahasiswa.')->withInput();
        }
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $mhs = Mahasiswa::findOrFail($id);
            $mhs->delete();
            Log::info('Student deleted successfully', ['id' => $id]);

            return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
        } catch (ModelNotFoundException $e) {
            Log::warning('Student not found for deletion', ['id' => $id]);

            return redirect()->route('mahasiswa.index')->with('error', 'Mahasiswa tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error deleting student', ['id' => $id, 'error' => $e->getMessage()]);

            return redirect()->route('mahasiswa.index')->with('error', 'Terjadi kesalahan saat menghapus mahasiswa.');
        }
    }
}
