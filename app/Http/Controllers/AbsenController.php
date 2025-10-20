<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Absen;
use App\Models\Mahasiswa;

class AbsenController extends Controller
{
    public function index()
    {
        $absens = Absen::with('mahasiswa')->get()->all();;
        return view('absen.index', compact('absens'));
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::all();
        return view('absen.create', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id_mahasiswa',
            'tanggal' => 'required|date',
            'waktu' => 'required|date_format:H:i',
            'status' => 'required',
            'keterangan' => 'nullable',
            'bukti_absen' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);

        // Check if today is Saturday (6) or Sunday (0)
        $dayOfWeek = date('w', strtotime($data['tanggal']));
        if ($dayOfWeek == 0 || $dayOfWeek == 6) {
            return redirect()->back()->with('error', 'Absen tidak tersedia pada hari Sabtu dan Minggu.');
        }

        // Check if student already has attendance for today
        $existingAbsen = Absen::where('id_mahasiswa', $data['id_mahasiswa'])
            ->where('tanggal', $data['tanggal'])
            ->first();

        if ($existingAbsen) {
            return redirect()->back()->with('error', 'Anda sudah absen hari ini. Absen berikutnya dapat dilakukan besok.');
        }

        if ($request->hasFile('bukti_absen')) {
            $data['bukti_absen'] = $request->file('bukti_absen')->store('bukti_absen', 'public');
        }
        Absen::create($data);
        return redirect()->back()->with('success', 'Absen berhasil ditambahkan.');
    }

    public function show($id)
    {
        $absen = Absen::with('mahasiswa')->findOrFail($id);
        return view('absen.show', compact('absen'));
    }

    public function edit($id)
    {
        $absen = Absen::findOrFail($id);
        $mahasiswa = Mahasiswa::all();
        return view('absen.edit', compact('absen', 'mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $absen = Absen::findOrFail($id);
        $data = $request->validate([
            'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id_mahasiswa',
            'tanggal' => 'required|date',
            'waktu' => 'required|date_format:H:i',
            'status' => 'required',
            'keterangan' => 'nullable',
            'bukti_absen' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);
        if ($request->hasFile('bukti_absen')) {
            $data['bukti_absen'] = $request->file('bukti_absen')->store('bukti_absen', 'public');
        }
        $absen->update($data);
        return redirect()->route('absen.index')->with('success', 'Absen berhasil diupdate.');
    }

    public function destroy($id)
    {
        $absen = Absen::findOrFail($id);
        $absen->delete();
        return redirect()->route('absen.index')->with('success', 'Absen berhasil dihapus.');
    }
}