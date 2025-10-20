<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Laporan;
use App\Models\Mahasiswa;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Laporan::with('mahasiswa')->get()->all();
        return view('laporan.index', compact('laporan'));
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::all();
        return view('laporan.create', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id_mahasiswa',
            'tanggal' => 'required|date',
            'judul' => 'required',
            'isi_laporan' => 'required',
            'file_laporan' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);
        if ($request->hasFile('file_laporan')) {
            $data['file_laporan'] = $request->file('file_laporan')->store('file_laporan', 'public');
        }
        Laporan::create($data);
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function show(Laporan $laporan)
    {
        $laporan->load('mahasiswa');
        return view('laporan.show', compact('laporan'));
    }

    public function edit(Laporan $laporan)
    {
        $mahasiswa = Mahasiswa::all();
        return view('laporan.edit', compact('laporan', 'mahasiswa'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $data = $request->validate([
            'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id_mahasiswa',
            'tanggal' => 'required|date',
            'judul' => 'required',
            'isi_laporan' => 'required',
            'file_laporan' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);
        if ($request->hasFile('file_laporan')) {
            $data['file_laporan'] = $request->file('file_laporan')->store('file_laporan', 'public');
        }
        $laporan->update($data);
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diupdate.');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
