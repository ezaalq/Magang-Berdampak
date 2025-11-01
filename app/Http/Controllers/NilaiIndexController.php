<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\NilaiIndex;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Controller for managing index scores (NilaiIndex)
 */
class NilaiIndexController extends Controller
{
    /**
     * Display a listing of index scores.
     */
    public function index(): View
    {
        $nilai_index = NilaiIndex::with('mahasiswa')->get();

        return view('nilai_index.index', compact('nilai_index'));
    }

    /**
     * Show the form for creating a new index score.
     */
    public function create(): View
    {
        $mahasiswa = Mahasiswa::all();

        return view('nilai_index.create', compact('mahasiswa'));
    }

    /**
     * Store a newly created index score in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info('NilaiIndexController@store called', ['request' => $request->all()]);

        try {
            $data = $request->validate([
                'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id',
                'nilai_index' => 'required|numeric|min:0|max:100',
                'status' => 'required|string|max:50',
            ]);

            NilaiIndex::create($data);
            Log::info('Index score created successfully', ['id_mahasiswa' => $data['id_mahasiswa'], 'nilai_index' => $data['nilai_index']]);

            return redirect()->route('nilai_index.index')->with('success', 'Nilai Index berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating index score', ['error' => $e->getMessage(), 'request' => $request->all()]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan nilai index.')->withInput();
        }
    }

    /**
     * Display the specified index score.
     */
    public function show(int $id): View
    {
        try {
            $nilai = NilaiIndex::with('mahasiswa')->findOrFail($id);

            return view('nilai_index.show', compact('nilai'));
        } catch (ModelNotFoundException $e) {
            Log::warning('Index score not found', ['id' => $id]);
            abort(404, 'Nilai Index tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified index score.
     */
    public function edit(int $id): View
    {
        try {
            $nilai = NilaiIndex::findOrFail($id);
            $mahasiswa = Mahasiswa::all();

            return view('nilai_index.edit', compact('nilai', 'mahasiswa'));
        } catch (ModelNotFoundException $e) {
            Log::warning('Index score not found for editing', ['id' => $id]);
            abort(404, 'Nilai Index tidak ditemukan.');
        }
    }

    /**
     * Update the specified index score in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        Log::info('NilaiIndexController@update called', ['id' => $id, 'request' => $request->all()]);

        try {
            $nilai = NilaiIndex::findOrFail($id);
            $data = $request->validate([
                'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id',
                'nilai_index' => 'required|numeric|min:0|max:100',
                'status' => 'required|string|max:50',
            ]);

            $nilai->update($data);
            Log::info('Index score updated successfully', ['id' => $id]);

            return redirect()->route('nilai_index.index')->with('success', 'Nilai Index berhasil diupdate.');
        } catch (ModelNotFoundException $e) {
            Log::warning('Index score not found for update', ['id' => $id]);

            return redirect()->route('nilai_index.index')->with('error', 'Nilai Index tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error updating index score', ['id' => $id, 'error' => $e->getMessage(), 'request' => $request->all()]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate nilai index.')->withInput();
        }
    }

    /**
     * Remove the specified index score from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $nilai = NilaiIndex::findOrFail($id);
            $nilai->delete();
            Log::info('Index score deleted successfully', ['id' => $id]);

            return redirect()->route('nilai_index.index')->with('success', 'Nilai Index berhasil dihapus.');
        } catch (ModelNotFoundException $e) {
            Log::warning('Index score not found for deletion', ['id' => $id]);

            return redirect()->route('nilai_index.index')->with('error', 'Nilai Index tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error deleting index score', ['id' => $id, 'error' => $e->getMessage()]);

            return redirect()->route('nilai_index.index')->with('error', 'Terjadi kesalahan saat menghapus nilai index.');
        }
    }
}
