<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kegiatan;
use App\Models\Laporan;
use App\Models\Absen;
use Illuminate\Http\Request;
use App\Models\AnggotaNonSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $total_mahasiswa = Mahasiswa::count();
        $total_kegiatan = Kegiatan::count();
        $total_laporan = Laporan::count();
        $kegiatan_terbaru = Kegiatan::latest()->take(5)->get();
        $laporan_terbaru = Laporan::latest()->take(5)->get();

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

        return view('dashboard', compact(
            'total_mahasiswa',
            'total_kegiatan',
            'total_laporan',
            'kegiatan_terbaru',
            'laporan_terbaru',
            'isWeekend',
            'userHasAttended'
        ));
    }
}