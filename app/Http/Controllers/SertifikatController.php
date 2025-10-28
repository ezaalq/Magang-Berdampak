<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

use App\Models\Sertifikat;
use App\Models\Mahasiswa;

class SertifikatController extends Controller
{
    public function index()
    {
        $sertifikat = Sertifikat::with('mahasiswa')->get()->all();;
        return view('sertifikat.index', compact('sertifikat'));
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::all();
        return view('sertifikat.create', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id_mahasiswa',
            'nama_sertifikat' => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        // Fetch student data
        $mahasiswa = Mahasiswa::findOrFail($data['id_mahasiswa']);

        // Generate PDF
        $pdf = Pdf::loadView('sertifikat.certificate', compact('mahasiswa', 'data'));

        // Save PDF to storage
        $filename = 'certificate_' . $data['id_mahasiswa'] . '_' . time() . '.pdf';
        $path = 'certificates/' . $filename;
        Storage::disk('public')->put($path, $pdf->output());

        $data['file_sertifikat'] = $path;

        Sertifikat::create($data);
        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function show($id)
    {
        $sertifikat = Sertifikat::with('mahasiswa')->findOrFail($id);
        return view('sertifikat.show', compact('sertifikat'));
    }

    public function edit($id)
    {
        $sertifikat = Sertifikat::findOrFail($id);
        $mahasiswa = Mahasiswa::all();
        return view('sertifikat.edit', compact('sertifikat', 'mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $sertifikat = Sertifikat::findOrFail($id);
        $data = $request->validate([
            'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id_mahasiswa',
            'nama_sertifikat' => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        // Fetch student data
        $mahasiswa = Mahasiswa::findOrFail($data['id_mahasiswa']);

        // Generate PDF
        $pdf = Pdf::loadView('sertifikat.certificate', compact('mahasiswa', 'data'));

        // Save PDF to storage
        $filename = 'certificate_' . $data['id_mahasiswa'] . '_' . time() . '.pdf';
        $path = 'certificates/' . $filename;
        Storage::disk('public')->put($path, $pdf->output());

        $data['file_sertifikat'] = $path;

        $sertifikat->update($data);
        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil diupdate.');
    }

    public function destroy($id)
    {
        $sertifikat = Sertifikat::findOrFail($id);
        if ($sertifikat->file_sertifikat && Storage::disk('public')->exists($sertifikat->file_sertifikat)) {
            Storage::disk('public')->delete($sertifikat->file_sertifikat);
        }
        $sertifikat->delete();
        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil dihapus.');
    }
}
