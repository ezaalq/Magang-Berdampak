<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'file_sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);
        if ($request->hasFile('file_sertifikat')) {
            $data['file_sertifikat'] = $request->file('file_sertifikat')->store('file_sertifikat', 'public');
        }
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
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);
        if ($request->hasFile('file_sertifikat')) {
            $data['file_sertifikat'] = $request->file('file_sertifikat')->store('file_sertifikat', 'public');
        }
        $sertifikat->update($data);
        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil diupdate.');
    }

    public function destroy($id)
    {
        $sertifikat = Sertifikat::findOrFail($id);
        $sertifikat->delete();
        return redirect()->route('sertifikat.index')->with('success', 'Sertifikat berhasil dihapus.');
    }
}
