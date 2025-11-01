<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Sertifikat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Controller for managing certificates (Sertifikat)
 */
class SertifikatController extends Controller
{
    /**
     * Display a listing of certificates.
     */
    public function index(): View
    {
        $sertifikat = Sertifikat::with('mahasiswa')->get();

        return view('sertifikat.index', compact('sertifikat'));
    }

    /**
     * Show the form for creating a new certificate.
     */
    public function create(): View
    {
        $mahasiswa = Mahasiswa::all();

        return view('sertifikat.create', compact('mahasiswa'));
    }

    /**
     * Store a newly created certificate in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info('SertifikatController@store called', ['request' => $request->all()]);

        try {
            $data = $request->validate([
                'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id',
                'nama_sertifikat' => 'required|string|max:255',
                'tanggal_terbit' => 'required|date',
                'deskripsi' => 'nullable|string',
            ]);

            // Fetch student data
            $mahasiswa = Mahasiswa::findOrFail($data['id_mahasiswa']);

            // Generate PDF
            $pdf = Pdf::loadView('sertifikat.certificate', compact('mahasiswa', 'data'))->setPaper('a4', 'landscape');

            // Save PDF to storage
            $filename = 'certificate_'.$data['id_mahasiswa'].'_'.time().'.pdf';
            $path = 'certificates/'.$filename;
            Storage::disk('public')->put($path, $pdf->output());

            $data['file_sertifikat'] = $path;

            Sertifikat::create($data);
            Log::info('Certificate created successfully', ['id_mahasiswa' => $data['id_mahasiswa']]);

            return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating certificate', ['error' => $e->getMessage(), 'request' => $request->all()]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat sertifikat.')->withInput();
        }
    }

    /**
     * Display the specified certificate.
     */
    public function show(int $id): View
    {
        try {
            $sertifikat = Sertifikat::with('mahasiswa')->findOrFail($id);

            return view('sertifikat.show', compact('sertifikat'));
        } catch (ModelNotFoundException $e) {
            Log::warning('Certificate not found', ['id' => $id]);
            abort(404, 'Sertifikat tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified certificate.
     */
    public function edit(int $id): View
    {
        try {
            $sertifikat = Sertifikat::findOrFail($id);
            $mahasiswa = Mahasiswa::all();

            return view('sertifikat.edit', compact('sertifikat', 'mahasiswa'));
        } catch (ModelNotFoundException $e) {
            Log::warning('Certificate not found for editing', ['id' => $id]);
            abort(404, 'Sertifikat tidak ditemukan.');
        }
    }

    /**
     * Update the specified certificate in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        Log::info('SertifikatController@update called', ['id' => $id, 'request' => $request->all()]);

        try {
            $sertifikat = Sertifikat::findOrFail($id);
            $data = $request->validate([
                'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id',
                'nama_sertifikat' => 'required|string|max:255',
                'tanggal_terbit' => 'required|date',
                'deskripsi' => 'nullable|string',
            ]);

            // Fetch student data
            $mahasiswa = Mahasiswa::findOrFail($data['id_mahasiswa']);

            // Generate PDF
            $pdf = Pdf::loadView('sertifikat.certificate', compact('mahasiswa', 'data'))->setPaper('a4', 'landscape');

            // Save PDF to storage
            $filename = 'certificate_'.$data['id_mahasiswa'].'_'.time().'.pdf';
            $path = 'certificates/'.$filename;
            Storage::disk('public')->put($path, $pdf->output());

            $data['file_sertifikat'] = $path;

            $sertifikat->update($data);
            Log::info('Certificate updated successfully', ['id' => $id]);

            return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil diupdate.');
        } catch (ModelNotFoundException $e) {
            Log::warning('Certificate not found for update', ['id' => $id]);

            return redirect()->route('sertifikat.index')->with('error', 'Sertifikat tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error updating certificate', ['id' => $id, 'error' => $e->getMessage(), 'request' => $request->all()]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate sertifikat.')->withInput();
        }
    }

    /**
     * Remove the specified certificate from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $sertifikat = Sertifikat::findOrFail($id);
            if ($sertifikat->file_sertifikat && Storage::disk('public')->exists($sertifikat->file_sertifikat)) {
                Storage::disk('public')->delete($sertifikat->file_sertifikat);
            }
            $sertifikat->delete();
            Log::info('Certificate deleted successfully', ['id' => $id]);

            return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil dihapus.');
        } catch (ModelNotFoundException $e) {
            Log::warning('Certificate not found for deletion', ['id' => $id]);

            return redirect()->route('sertifikat.index')->with('error', 'Sertifikat tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error deleting certificate', ['id' => $id, 'error' => $e->getMessage()]);

            return redirect()->route('sertifikat.index')->with('error', 'Terjadi kesalahan saat menghapus sertifikat.');
        }
    }
}