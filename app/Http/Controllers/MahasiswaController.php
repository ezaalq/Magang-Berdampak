<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nim' => 'required|unique:tabel_mahasiswa,nim',
            'nama' => 'required',
            'email' => 'required|email|unique:tabel_mahasiswa,email',
            'asal_sekolah' => 'nullable',
            'jurusan' => 'nullable',
            'alamat' => 'nullable',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png',
            'password' => 'required',
            'role' => 'required',
        ]);
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_mahasiswa', 'public');
        }
        $data['password'] = bcrypt($data['password']);
        Mahasiswa::create($data);
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function show($id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        return view('mahasiswa.show', compact('mhs'));
    }

    public function edit($id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        return view('mahasiswa.edit', compact('mhs'));
    }

    public function update(Request $request, $id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        $data = $request->validate([
            'nim' => 'required|unique:tabel_mahasiswa,nim,' . $id . ',id_mahasiswa',
            'nama' => 'required',
            'email' => 'required|email|unique:tabel_mahasiswa,email,' . $id . ',id_mahasiswa',
            'asal_sekolah' => 'nullable',
            'jurusan' => 'nullable',
            'alamat' => 'nullable',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png',
            'password' => 'nullable',
            'role' => 'required',
        ]);
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_mahasiswa', 'public');
        }
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        $mhs->update($data);
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diupdate.');
    }

    public function destroy($id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        $mhs->delete();
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }
}