<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Kegiatan;
use App\Models\Mahasiswa;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::with('mahasiswa')->get()->all();;
        return view('kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::all();
        return view('kegiatan.create', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id_mahasiswa',
            'judul' => 'required',
            'kategori' => 'required',
            'file_kegiatan' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'status' => 'required',
        ]);
        if ($request->hasFile('file_kegiatan')) {
            $data['file_kegiatan'] = $request->file('file_kegiatan')->store('file_kegiatan', 'public');
        }
        Kegiatan::create($data);
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::with('mahasiswa')->findOrFail($id);
        return view('kegiatan.show', compact('kegiatan'));
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $mahasiswa = Mahasiswa::all();
        return view('kegiatan.edit', compact('kegiatan', 'mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $data = $request->validate([
            'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id_mahasiswa',
            'judul' => 'required',
            'kategori' => 'required',
            'file_kegiatan' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'status' => 'required',
        ]);
        if ($request->hasFile('file_kegiatan')) {
            $data['file_kegiatan'] = $request->file('file_kegiatan')->store('file_kegiatan', 'public');
        }
        $kegiatan->update($data);
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
