<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Kegiatan;
use App\Models\Laporan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * Controller for dashboard functionality
 */
class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics and recent data.
     */
    public function index(Request $request): View
    {
        try {
            Log::info('DashboardController@index accessed', ['user_id' => Auth::id()]);

            $total_mahasiswa = Mahasiswa::count();
            $total_kegiatan = Kegiatan::count();
            $total_laporan = Laporan::count();
            $kegiatan_terbaru = Kegiatan::with('mahasiswa')->latest()->take(5)->get();
            $laporan_terbaru = Laporan::with('mahasiswa')->latest()->take(5)->get();

            // Check if today is weekend
            $today = date('Y-m-d');
            $dayOfWeek = date('w', strtotime($today));
            $isWeekend = ($dayOfWeek == 0 || $dayOfWeek == 6);

            // Check if user has already attended today
            $userHasAttended = false;
            if (Auth::check() && Auth::user()->id_mahasiswa) {
                $userHasAttended = Absen::where('id_mahasiswa', Auth::user()->id_mahasiswa)
                    ->where('tanggal', $today)
                    ->exists();
            }

            Log::info('Dashboard data loaded successfully', [
                'total_mahasiswa' => $total_mahasiswa,
                'total_kegiatan' => $total_kegiatan,
                'total_laporan' => $total_laporan,
            ]);

            return view('dashboard', compact(
                'total_mahasiswa',
                'total_kegiatan',
                'total_laporan',
                'kegiatan_terbaru',
                'laporan_terbaru',
                'isWeekend',
                'userHasAttended'
            ));
        } catch (\Exception $e) {
            Log::error('Error loading dashboard', ['error' => $e->getMessage(), 'user_id' => Auth::id()]);
            abort(500, 'Terjadi kesalahan saat memuat dashboard.');
        }
    }
}
