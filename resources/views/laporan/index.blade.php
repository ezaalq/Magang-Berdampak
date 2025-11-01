@extends('layouts.master')

@section('title', 'Data Laporan')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Laporan</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahLaporan">
                Tambah Laporan
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
                            <th>Judul</th>
                            <th>Isi Laporan</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan as $lap)
                            <tr>
                                <td>{{ $lap->mahasiswa->nim ?? '-' }}</td>
                                <td>{{ $lap->mahasiswa->nama ?? '-' }}</td>
                                <td>{{ $lap->tanggal }}</td>
                                <td>{{ $lap->judul }}</td>
                                <td>{{ Str::limit($lap->isi_laporan, 30) }}</td>
                                <td>
                                    @if ($lap->file_laporan)
                                        <a href="{{ asset("storage/{$lap->file_laporan}") }}" target="_blank">Lihat</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal"
                                        data-bs-target="#modalEditLaporan{{ $lap->id }}">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#modalHapusLaporan{{ $lap->id }}">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modals for Edit and Delete -->
        @foreach ($laporan as $lap)
            <!-- Modal Edit Laporan -->
            <div class="modal fade" id="modalEditLaporan{{ $lap->id }}" tabindex="-1"
                aria-labelledby="modalEditLaporanLabel{{ $lap->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('laporan.update', $lap->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditLaporanLabel{{ $lap->id }}">Edit Laporan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="id_mahasiswa_edit{{ $lap->id }}"
                                        class="form-label">Mahasiswa</label>
                                    <select class="form-select" id="id_mahasiswa_edit{{ $lap->id }}"
                                        name="id_mahasiswa" required>
                                        <option value="">Pilih Mahasiswa</option>
                                        @foreach (\App\Models\Mahasiswa::all() as $mhs)
                                            <option value="{{ $mhs->id }}"
                                                {{ $lap->id_mahasiswa == $mhs->id ? 'selected' : '' }}>
                                                {{ $mhs->nim }} - {{ $mhs->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_edit{{ $lap->id }}" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal_edit{{ $lap->id }}"
                                        name="tanggal" value="{{ $lap->tanggal }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="judul_edit{{ $lap->id }}" class="form-label">Judul</label>
                                    <input type="text" class="form-control" id="judul_edit{{ $lap->id }}"
                                        name="judul" value="{{ $lap->judul }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="isi_laporan_edit{{ $lap->id }}" class="form-label">Isi
                                        Laporan</label>
                                    <textarea class="form-control" id="isi_laporan_edit{{ $lap->id }}" name="isi_laporan" rows="3" required>{{ $lap->isi_laporan }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="file_laporan_edit{{ $lap->id }}" class="form-label">File Laporan
                                        (Kosongkan jika tidak ingin mengubah)</label>
                                    <input type="file" class="form-control" id="file_laporan_edit{{ $lap->id }}"
                                        name="file_laporan" accept="image/*,application/pdf">
                                    @if ($lap->file_laporan)
                                        <small class="text-muted">File saat ini: <a
                                                href="{{ asset("storage/{$lap->file_laporan}") }}"
                                                target="_blank">Lihat</a></small>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal Hapus Laporan -->
            <div class="modal fade" id="modalHapusLaporan{{ $lap->id }}" tabindex="-1"
                aria-labelledby="modalHapusLaporanLabel{{ $lap->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('laporan.destroy', $lap->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalHapusLaporanLabel{{ $lap->id }}">Konfirmasi Hapus
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Yakin ingin menghapus laporan <strong>{{ $lap->judul }}</strong>?</p>
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

        <!-- Modal Tambah Laporan -->
        <div class="modal fade" id="modalTambahLaporan" tabindex="-1" aria-labelledby="modalTambahLaporanLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLaporanLabel">Tambah Laporan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id_mahasiswa" class="form-label">Mahasiswa</label>
                                <select class="form-select" id="id_mahasiswa" name="id_mahasiswa" required>
                                    <option value="">Pilih Mahasiswa</option>
                                    @foreach (\App\Models\Mahasiswa::all() as $mhs)
                                        <option value="{{ $mhs->id }}">{{ $mhs->nim }} -
                                            {{ $mhs->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                            </div>
                            <div class="mb-3">
                                <label for="isi_laporan" class="form-label">Isi Laporan</label>
                                <textarea class="form-control" id="isi_laporan" name="isi_laporan" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="file_laporan" class="form-label">File Laporan (opsional)</label>
                                <input type="file" class="form-control" id="file_laporan" name="file_laporan"
                                    accept="image/*,application/pdf">
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
