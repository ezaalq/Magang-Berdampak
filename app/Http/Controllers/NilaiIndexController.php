<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\NilaiIndex;
use App\Models\Mahasiswa;

class NilaiIndexController extends Controller
{
    public function index()
    {
        $nilai_index = NilaiIndex::with('mahasiswa')->get()->all();;
        return view('nilai_index.index', compact('nilai_index'));
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::all();
        return view('nilai_index.create', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id_mahasiswa',
            'nilai_index' => 'required|numeric',
            'status' => 'required',
        ]);
        NilaiIndex::create($data);
        return redirect()->route('nilai_index.index')->with('success', 'Nilai Index berhasil ditambahkan.');
    }

    public function show($id)
    {
        $nilai = NilaiIndex::with('mahasiswa')->findOrFail($id);
        return view('nilai_index.show', compact('nilai'));
    }

    public function edit($id)
    {
        $nilai = NilaiIndex::findOrFail($id);
        $mahasiswa = Mahasiswa::all();
        return view('nilai_index.edit', compact('nilai', 'mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $nilai = NilaiIndex::findOrFail($id);
        $data = $request->validate([
            'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id_mahasiswa',
            'nilai_index' => 'required|numeric',
            'status' => 'required',
        ]);
        $nilai->update($data);
        return redirect()->route('nilai_index.index')->with('success', 'Nilai Index berhasil diupdate.');
    }

    public function destroy($id)
    {
        $nilai = NilaiIndex::findOrFail($id);
        $nilai->delete();
        return redirect()->route('nilai_index.index')->with('success', 'Nilai Index berhasil dihapus.');
    }
}
