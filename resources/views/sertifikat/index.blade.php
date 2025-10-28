@extends('layouts.master')

@section('title', 'Data Sertifikat')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Sertifikat</h5>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSertifikat">
            Tambah Sertifikat
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nim</th>
                        <th>Nama Mahasiswa</th>
                        <th>Nama Sertifikat</th>
                        <th>Tanggal Terbit</th>
                        <th>Deskripsi</th>
                        <th>File Sertifikat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\Sertifikat::with('mahasiswa')->get() as $sertifikat)
                    <tr>
                        <td>{{ $sertifikat->mahasiswa->nim ?? '-' }}</td>
                        <td>{{ $sertifikat->mahasiswa->nama ?? '-' }}</td>
                        <td>{{ $sertifikat->nama_sertifikat ?? '-' }}</td>
                        <td>{{ $sertifikat->tanggal_terbit ? \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $sertifikat->deskripsi ?? '-' }}</td>
                        <td>
                            @if($sertifikat->file_sertifikat)
                                <a href="{{ asset('storage/' . $sertifikat->file_sertifikat) }}" target="_blank">Lihat Sertifikat</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEditSertifikat{{ $sertifikat->id_sertifikat }}">Edit</button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusSertifikat{{ $sertifikat->id_sertifikat }}">Hapus</button>
                        </td>
                    <!-- Modal Edit Sertifikat -->
                    <div class="modal fade" id="modalEditSertifikat{{ $sertifikat->id_sertifikat }}" tabindex="-1" aria-labelledby="modalEditSertifikatLabel{{ $sertifikat->id_sertifikat }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('sertifikat.update', $sertifikat->id_sertifikat) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditSertifikatLabel{{ $sertifikat->id_sertifikat }}">Edit Sertifikat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="id_mahasiswa_edit{{ $sertifikat->id_sertifikat }}" class="form-label">Mahasiswa</label>
                                            <select class="form-select" id="id_mahasiswa_edit{{ $sertifikat->id_sertifikat }}" name="id_mahasiswa" required>
                                                <option value="">Pilih Mahasiswa</option>
                                                @foreach(\App\Models\Mahasiswa::all() as $mhs)
                                                    <option value="{{ $mhs->id_mahasiswa }}" {{ $sertifikat->id_mahasiswa == $mhs->id_mahasiswa ? 'selected' : '' }}>{{ $mhs->nim }} - {{ $mhs->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama_sertifikat_edit{{ $sertifikat->id_sertifikat }}" class="form-label">Nama Sertifikat</label>
                                            <input type="text" class="form-control" id="nama_sertifikat_edit{{ $sertifikat->id_sertifikat }}" name="nama_sertifikat" value="{{ $sertifikat->nama_sertifikat }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal_terbit_edit{{ $sertifikat->id_sertifikat }}" class="form-label">Tanggal Terbit</label>
                                            <input type="date" class="form-control" id="tanggal_terbit_edit{{ $sertifikat->id_sertifikat }}" name="tanggal_terbit" value="{{ $sertifikat->tanggal_terbit }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="deskripsi_edit{{ $sertifikat->id_sertifikat }}" class="form-label">Deskripsi</label>
                                            <textarea class="form-control" id="deskripsi_edit{{ $sertifikat->id_sertifikat }}" name="deskripsi" rows="3">{{ $sertifikat->deskripsi }}</textarea>
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
                    <!-- Modal Hapus Sertifikat -->
                    <div class="modal fade" id="modalHapusSertifikat{{ $sertifikat->id_sertifikat }}" tabindex="-1" aria-labelledby="modalHapusSertifikatLabel{{ $sertifikat->id_sertifikat }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('sertifikat.destroy', $sertifikat->id_sertifikat) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalHapusSertifikatLabel{{ $sertifikat->id_sertifikat }}">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Yakin ingin menghapus sertifikat <strong>{{ $sertifikat->mahasiswa->nama ?? '-' }}</strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>

        <!-- Modal Tambah Sertifikat -->
        <div class="modal fade" id="modalTambahSertifikat" tabindex="-1" aria-labelledby="modalTambahSertifikatLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('sertifikat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahSertifikatLabel">Tambah Sertifikat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id_mahasiswa" class="form-label">Mahasiswa</label>
                                <select class="form-select" id="id_mahasiswa" name="id_mahasiswa" required>
                                    <option value="">Pilih Mahasiswa</option>
                                    @foreach(\App\Models\Mahasiswa::all() as $mhs)
                                        <option value="{{ $mhs->id_mahasiswa }}">{{ $mhs->nim }} - {{ $mhs->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nama_sertifikat" class="form-label">Nama Sertifikat</label>
                                <input type="text" class="form-control" id="nama_sertifikat" name="nama_sertifikat" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                                <input type="date" class="form-control" id="tanggal_terbit" name="tanggal_terbit" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
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
