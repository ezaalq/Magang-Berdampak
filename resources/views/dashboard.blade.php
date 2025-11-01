@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-12 col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Mahasiswa</h6>
                <h2 class="fw-bold mb-0">{{ $total_mahasiswa }}</h2>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Kegiatan</h6>
                <h2 class="fw-bold mb-0">{{ $total_kegiatan }}</h2>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h6 class="card-title text-muted">Total Laporan</h6>
                <h2 class="fw-bold mb-0">{{ $total_laporan }}</h2>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card text-center shadow-sm text-white">
            <div class="card-body">
                <h6 class="card-title">Absen Hari Ini</h6>
                @if($isWeekend)
                    <div class="text-warning">
                        <i class="bx bx-calendar-x"></i> Hari Libur
                    </div>
                    <small class="text-light">Absen tidak tersedia di akhir pekan</small>
                @elseif($userHasAttended)
                    <div class="text-success">
                        <i class="bx bx-check-circle"></i> Sudah Absen
                    </div>
                    <small class="text-light">Absen berikutnya besok</small>
                @else
                    <button type="button" class="btn btn-light bg-warning" data-bs-toggle="modal" data-bs-target="#absenModal">
                        <i class="bx bx-check-circle"></i> Absen Sekarang
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row g-4">
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Kegiatan Terbaru</div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($kegiatan_terbaru as $kegiatan)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $kegiatan->judul }} <span class="badge bg-info ms-2">{{ $kegiatan->kategori }}</span></span>
                            <span class="badge bg-secondary">
                                @if($kegiatan->status === 'Disetujui')
                                    Disetujui
                                @elseif($kegiatan->status === 'Menunggu')
                                    Menunggu
                                @elseif($kegiatan->status === 'Ditolak')
                                    Ditolak
                                @else
                                    {{ ucfirst($kegiatan->status) }}
                                @endif
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">Belum ada kegiatan</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">Laporan Terbaru</div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($laporan_terbaru as $laporan)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $laporan->judul }}</span>
                            <span class="badge bg-primary">{{ $laporan->tanggal }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">Belum ada laporan</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal Absen -->
<div class="modal fade" id="absenModal" tabindex="-1" aria-labelledby="absenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="absenModalLabel">Absen Hari Ini</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('absen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="waktu" class="form-label">Waktu</label>
                        <input type="time" class="form-control" id="waktu" name="waktu" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alpa">Alpa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Tambahkan keterangan jika diperlukan"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="bukti_absen" class="form-label">Bukti Absen (Opsional)</label>
                        <input type="file" class="form-control" id="bukti_absen" name="bukti_absen" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                    <input type="hidden" name="id_mahasiswa" value="{{ auth()->user()->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Absen</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
// Set current time when modal is shown
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('absenModal');
    modal.addEventListener('show.bs.modal', function () {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const currentTime = `${hours}:${minutes}`;
        const timeInput = document.getElementById('waktu');
        if (timeInput) {
            timeInput.value = currentTime;
            console.log('Time set to:', currentTime); // Debug log
        }
    });
});
</script>
