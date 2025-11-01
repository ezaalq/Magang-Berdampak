@extends('layouts.master')

@section('title', 'Data Absen')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Absen</h5>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAbsen">
            Tambah Absen
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nim</th>
                        <th>Nama Mahasiswa</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Bukti Absen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                                        @foreach(\App\Models\Absen::with('mahasiswa')->get() as $absen)
                                        <tr>
                                                <td>{{ $absen->mahasiswa->nim ?? '-' }}</td>
                                                <td>{{ $absen->mahasiswa->nama ?? '-' }}</td>
                                                <td>{{ $absen->tanggal }}</td>
                                                <td>{{ $absen->waktu ?? '-' }}</td>
                                                <td><span class="badge bg-{{ $absen->status == 'hadir' ? 'success' : ($absen->status == 'izin' ? 'warning' : 'danger') }}">{{ ucfirst($absen->status) }}</span></td>
                                                <td>{{ $absen->keterangan }}</td>
                                                <td>
                                                        @if($absen->bukti_absen)
                                                                <a href="{{ asset('storage/' . $absen->bukti_absen) }}" target="_blank">Lihat</a>
                                                        @else
                                                                -
                                                        @endif
                                                </td>
                                                <td>
                                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditAbsen{{ $absen->id }}">Edit</button>
                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusAbsen{{ $absen->id }}">Hapus</button>
                                                </td>
                                        </tr>

                                        <!-- Modal Edit Absen -->
                                        <div class="modal fade" id="modalEditAbsen{{ $absen->id }}" tabindex="-1" aria-labelledby="modalEditAbsenLabel{{ $absen->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('absen.update', $absen->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalEditAbsenLabel{{ $absen->id }}">Edit Absen</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="id_mahasiswa_edit{{ $absen->id }}" class="form-label">Mahasiswa</label>
                                                                <select class="form-select" id="id_mahasiswa_edit{{ $absen->id }}" name="id_mahasiswa" required>
                                                                    <option value="">Pilih Mahasiswa</option>
                                                                    @foreach(\App\Models\Mahasiswa::all() as $mhs)
                                                                        <option value="{{ $mhs->id_mahasiswa }}" {{ $absen->id_mahasiswa == $mhs->id_mahasiswa ? 'selected' : '' }}>{{ $mhs->nim }} - {{ $mhs->nama }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="tanggal_edit{{ $absen->id }}" class="form-label">Tanggal</label>
                                                                <input type="date" class="form-control" id="tanggal_edit{{ $absen->id }}" name="tanggal" value="{{ $absen->tanggal }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="waktu_edit{{ $absen->id }}" class="form-label">Waktu</label>
                                                                <input type="time" class="form-control" id="waktu_edit{{ $absen->id }}" name="waktu" value="{{ $absen->waktu }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="status_edit{{ $absen->id }}" class="form-label">Status</label>
                                                                <select class="form-select" id="status_edit{{ $absen->id }}" name="status" required>
                                                                    <option value="hadir" {{ $absen->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                                    <option value="izin" {{ $absen->status == 'izin' ? 'selected' : '' }}>Izin</option>
                                                                    <option value="alpa" {{ $absen->status == 'alpa' ? 'selected' : '' }}>Alpa</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="keterangan_edit{{ $absen->id }}" class="form-label">Keterangan</label>
                                                                <input type="text" class="form-control" id="keterangan_edit{{ $absen->id }}" name="keterangan" value="{{ $absen->keterangan }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="bukti_absen_edit{{ $absen->id }}" class="form-label">Bukti Absen (opsional)</label>
                                                                <input type="file" class="form-control" id="bukti_absen_edit{{ $absen->id }}" name="bukti_absen" accept="image/*,application/pdf">
                                                                @if($absen->bukti_absen)
                                                                    <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $absen->bukti_absen) }}" target="_blank">Lihat</a></small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Hapus Absen -->
                                        <div class="modal fade" id="modalHapusAbsen{{ $absen->id }}" tabindex="-1" aria-labelledby="modalHapusAbsenLabel{{ $absen->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('absen.destroy', $absen->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalHapusAbsenLabel{{ $absen->id }}">Konfirmasi Hapus</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Yakin ingin menghapus absen tanggal <strong>{{ $absen->tanggal }}</strong> untuk <strong>{{ $absen->mahasiswa->nama ?? '-' }}</strong>?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah Absen -->
        <div class="modal fade" id="modalTambahAbsen" tabindex="-1" aria-labelledby="modalTambahAbsenLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('absen.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahAbsenLabel">Tambah Absen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id_mahasiswa" class="form-label">Mahasiswa</label>
                                <select class="form-select" id="id_mahasiswa" name="id_mahasiswa" required>
                                    <option value="">Pilih Mahasiswa</option>
                                    @foreach(\App\Models\Mahasiswa::all() as $mhs)
                                        <option value="{{ $mhs->id }}">{{ $mhs->nim }} - {{ $mhs->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                            <div class="mb-3">
                                <label for="waktu" class="form-label">Waktu</label>
                                <input type="time" class="form-control" id="waktu" name="waktu" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="hadir">Hadir</option>
                                    <option value="izin">Izin</option>
                                    <option value="alpa">Alpa</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan">
                            </div>
                            <div class="mb-3">
                                <label for="bukti_absen" class="form-label">Bukti Absen (opsional)</label>
                                <input type="file" class="form-control" id="bukti_absen" name="bukti_absen" accept="image/*,application/pdf">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>
@endsection
