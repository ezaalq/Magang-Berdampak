<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Mahasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Controller for managing reports (Laporan)
 */
class LaporanController extends Controller
{
    /**
     * Display a listing of reports.
     */
    public function index(): View
    {
        $laporan = Laporan::with('mahasiswa')->get();

        return view('laporan.index', compact('laporan'));
    }

    /**
     * Show the form for creating a new report.
     */
    public function create(): View
    {
        $mahasiswa = Mahasiswa::all();

        return view('laporan.create', compact('mahasiswa'));
    }

    /**
     * Store a newly created report in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info('LaporanController@store called', ['request' => $request->all()]);

        try {
            $data = $request->validate([
                'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id',
                'tanggal' => 'required|date',
                'judul' => 'required|string|max:255',
                'isi_laporan' => 'required|string',
                'file_laporan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            ]);

            if ($request->hasFile('file_laporan')) {
                $data['file_laporan'] = $request->file('file_laporan')->store('file_laporan', 'public');
            }

            Laporan::create($data);
            Log::info('Report created successfully', ['id_mahasiswa' => $data['id_mahasiswa'], 'judul' => $data['judul']]);

            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating report', ['error' => $e->getMessage(), 'request' => $request->all()]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan laporan.')->withInput();
        }
    }

    /**
     * Display the specified report.
     */
    public function show(Laporan $laporan): View
    {
        $laporan->load('mahasiswa');

        return view('laporan.show', compact('laporan'));
    }

    /**
     * Show the form for editing the specified report.
     */
    public function edit(Laporan $laporan): View
    {
        $mahasiswa = Mahasiswa::all();

        return view('laporan.edit', compact('laporan', 'mahasiswa'));
    }

    /**
     * Update the specified report in storage.
     */
    public function update(Request $request, Laporan $laporan): RedirectResponse
    {
        Log::info('LaporanController@update called', ['id' => $laporan->id, 'request' => $request->all()]);

        try {
            $data = $request->validate([
                'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id',
                'tanggal' => 'required|date',
                'judul' => 'required|string|max:255',
                'isi_laporan' => 'required|string',
                'file_laporan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            ]);

            if ($request->hasFile('file_laporan')) {
                $data['file_laporan'] = $request->file('file_laporan')->store('file_laporan', 'public');
            }

            $laporan->update($data);
            Log::info('Report updated successfully', ['id' => $laporan->id]);

            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error('Error updating report', ['id' => $laporan->id, 'error' => $e->getMessage(), 'request' => $request->all()]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate laporan.')->withInput();
        }
    }

    /**
     * Remove the specified report from storage.
     */
    public function destroy(Laporan $laporan): RedirectResponse
    {
        try {
            $laporan->delete();
            Log::info('Report deleted successfully', ['id' => $laporan->id]);

            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting report', ['id' => $laporan->id, 'error' => $e->getMessage()]);

            return redirect()->route('laporan.index')->with('error', 'Terjadi kesalahan saat menghapus laporan.');
        }
    }
}