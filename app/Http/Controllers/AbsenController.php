<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Controller for managing attendance (Absen)
 */
class AbsenController extends Controller
{
    /**
     * Display a listing of attendance records.
     */
    public function index(): View
    {
        $absens = Absen::with('mahasiswa')->get();

        return view('absen.index', compact('absens'));
    }

    /**
     * Show the form for creating a new attendance record.
     */
    public function create(): View
    {
        $mahasiswa = Mahasiswa::all();

        return view('absen.create', compact('mahasiswa'));
    }

    /**
     * Store a newly created attendance record in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info('AbsenController@store called', ['request' => $request->all()]);

        try {
            $data = $request->validate([
                'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id',
                'tanggal' => 'required|date',
                'waktu' => 'required|date_format:H:i',
                'status' => 'required',
                'keterangan' => 'nullable',
                'bukti_absen' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            ]);

            // Check if today is Saturday (6) or Sunday (0)
            $dayOfWeek = date('w', strtotime($data['tanggal']));
            if ($dayOfWeek == 0 || $dayOfWeek == 6) {
                Log::warning('Attempted attendance on weekend', ['tanggal' => $data['tanggal']]);

                return redirect()->back()->with('error', 'Absen tidak tersedia pada hari Sabtu dan Minggu.')->withInput();
            }

            // Check if student already has attendance for today
            $existingAbsen = Absen::where('id_mahasiswa', $data['id_mahasiswa'])
                ->where('tanggal', $data['tanggal'])
                ->first();

            if ($existingAbsen) {
                Log::warning('Duplicate attendance attempt', ['id_mahasiswa' => $data['id_mahasiswa'], 'tanggal' => $data['tanggal']]);

                return redirect()->back()->with('error', 'Anda sudah absen hari ini. Absen berikutnya dapat dilakukan besok.')->withInput();
            }

            if ($request->hasFile('bukti_absen')) {
                $data['bukti_absen'] = $request->file('bukti_absen')->store('bukti_absen', 'public');
            }

            Absen::create($data);
            Log::info('Attendance record created successfully', ['id_mahasiswa' => $data['id_mahasiswa'], 'tanggal' => $data['tanggal']]);

            return redirect()->back()->with('success', 'Absen berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating attendance record', ['error' => $e->getMessage(), 'request' => $request->all()]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan absen.')->withInput();
        }
    }

    /**
     * Display the specified attendance record.
     */
    public function show(int $id): View
    {
        try {
            $absen = Absen::with('mahasiswa')->findOrFail($id);

            return view('absen.show', compact('absen'));
        } catch (ModelNotFoundException $e) {
            Log::warning('Attendance record not found', ['id' => $id]);
            abort(404, 'Absen tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified attendance record.
     */
    public function edit(int $id): View
    {
        try {
            $absen = Absen::findOrFail($id);
            $mahasiswa = Mahasiswa::all();

            return view('absen.edit', compact('absen', 'mahasiswa'));
        } catch (ModelNotFoundException $e) {
            Log::warning('Attendance record not found for editing', ['id' => $id]);
            abort(404, 'Absen tidak ditemukan.');
        }
    }

    /**
     * Update the specified attendance record in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        Log::info('AbsenController@update called', ['id' => $id, 'request' => $request->all()]);

        try {
            $absen = Absen::findOrFail($id);
            $data = $request->validate([
                'id_mahasiswa' => 'required|exists:tabel_mahasiswa,id',
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
            Log::info('Attendance record updated successfully', ['id' => $id]);

            return redirect()->route('absen.index')->with('success', 'Absen berhasil diupdate.');
        } catch (ModelNotFoundException $e) {
            Log::warning('Attendance record not found for update', ['id' => $id]);

            return redirect()->route('absen.index')->with('error', 'Absen tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error updating attendance record', ['id' => $id, 'error' => $e->getMessage(), 'request' => $request->all()]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate absen.')->withInput();
        }
    }

    /**
     * Remove the specified attendance record from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $absen = Absen::findOrFail($id);
            $absen->delete();
            Log::info('Attendance record deleted successfully', ['id' => $id]);

            return redirect()->route('absen.index')->with('success', 'Absen berhasil dihapus.');
        } catch (ModelNotFoundException $e) {
            Log::warning('Attendance record not found for deletion', ['id' => $id]);

            return redirect()->route('absen.index')->with('error', 'Absen tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error deleting attendance record', ['id' => $id, 'error' => $e->getMessage()]);

            return redirect()->route('absen.index')->with('error', 'Terjadi kesalahan saat menghapus absen.');
        }
    }
}
