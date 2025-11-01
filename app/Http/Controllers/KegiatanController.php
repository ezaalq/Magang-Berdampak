<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Controller for managing activities (Kegiatan)
 */
class KegiatanController extends Controller
{
    /**
     * Display a listing of activities.
     */
    public function index(): View
    {
        $kegiatan = Kegiatan::with('mahasiswa')->get();

        return view('kegiatan.index', compact('kegiatan'));
    }

    /**
     * Show the form for creating a new activity.
     */
    public function create(): View
    {
        $mahasiswa = Mahasiswa::all();

        return view('kegiatan.create', compact('mahasiswa'));
    }

    /**
     * Store a newly created activity in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info('KegiatanController@store called', ['request' => $request->all()]);

        try {
            $data = $request->validate([
                'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id',
                'judul' => 'required|string|max:255',
                'kategori' => 'required|string|max:255',
                'file_kegiatan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'status' => 'required|string|max:255',
            ]);

            if ($request->hasFile('file_kegiatan')) {
                $data['file_kegiatan'] = $request->file('file_kegiatan')->store('file_kegiatan', 'public');
            }

            Kegiatan::create($data);
            Log::info('Activity created successfully', ['id_mahasiswa' => $data['id_mahasiswa'], 'judul' => $data['judul']]);

            return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating activity', ['error' => $e->getMessage(), 'request' => $request->all()]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan kegiatan.')->withInput();
        }
    }

    /**
     * Display the specified activity.
     */
    public function show(int $id): View
    {
        try {
            $kegiatan = Kegiatan::with('mahasiswa')->findOrFail($id);

            return view('kegiatan.show', compact('kegiatan'));
        } catch (ModelNotFoundException $e) {
            Log::warning('Activity not found', ['id' => $id]);
            abort(404, 'Kegiatan tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified activity.
     */
    public function edit(int $id): View
    {
        try {
            $kegiatan = Kegiatan::findOrFail($id);
            $mahasiswa = Mahasiswa::all();

            return view('kegiatan.edit', compact('kegiatan', 'mahasiswa'));
        } catch (ModelNotFoundException $e) {
            Log::warning('Activity not found for editing', ['id' => $id]);
            abort(404, 'Kegiatan tidak ditemukan.');
        }
    }

    /**
     * Update the specified activity in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        Log::info('KegiatanController@update called', ['id' => $id, 'request' => $request->all()]);

        try {
            $kegiatan = Kegiatan::findOrFail($id);
            $data = $request->validate([
                'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id',
                'judul' => 'required|string|max:255',
                'kategori' => 'required|string|max:255',
                'file_kegiatan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'status' => 'required|string|max:255',
            ]);

            if ($request->hasFile('file_kegiatan')) {
                $data['file_kegiatan'] = $request->file('file_kegiatan')->store('file_kegiatan', 'public');
            }

            $kegiatan->update($data);
            Log::info('Activity updated successfully', ['id' => $id]);

            return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diupdate.');
        } catch (ModelNotFoundException $e) {
            Log::warning('Activity not found for update', ['id' => $id]);

            return redirect()->route('kegiatan.index')->with('error', 'Kegiatan tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error updating activity', ['id' => $id, 'error' => $e->getMessage(), 'request' => $request->all()]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate kegiatan.')->withInput();
        }
    }

    /**
     * Remove the specified activity from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $kegiatan = Kegiatan::findOrFail($id);
            $kegiatan->delete();
            Log::info('Activity deleted successfully', ['id' => $id]);

            return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
        } catch (ModelNotFoundException $e) {
            Log::warning('Activity not found for deletion', ['id' => $id]);

            return redirect()->route('kegiatan.index')->with('error', 'Kegiatan tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error deleting activity', ['id' => $id, 'error' => $e->getMessage()]);

            return redirect()->route('kegiatan.index')->with('error', 'Terjadi kesalahan saat menghapus kegiatan.');
        }
    }
}
