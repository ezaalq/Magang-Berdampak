@extends('layouts.master')

@section('title', 'Data Nilai Index')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Nilai Index</h5>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahNilaiIndex">
            Tambah Nilai Index
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nim</th>
                        <th>Nama Mahasiswa</th>
                        <th>Nilai Index</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\NilaiIndex::with('mahasiswa')->get() as $nilai)
                    <tr>
                        <td>{{ $nilai->mahasiswa->nim ?? '-' }}</td>
                        <td>{{ $nilai->mahasiswa->nama ?? '-' }}</td>
                        <td>{{ $nilai->nilai_index }}</td>
                        <td><span class="badge bg-{{ $nilai->status == 'lulus' ? 'success' : 'secondary' }}">{{ ucfirst($nilai->status) }}</span></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEditNilaiIndex{{ $nilai->id }}">Edit</button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusNilaiIndex{{ $nilai->id }}">Hapus</button>
                        </td>
                    </tr>
                    <!-- Modal Edit Nilai Index -->
                    <div class="modal fade" id="modalEditNilaiIndex{{ $nilai->id }}" tabindex="-1" aria-labelledby="modalEditNilaiIndexLabel{{ $nilai->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('nilai_index.update', $nilai->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditNilaiIndexLabel{{ $nilai->id }}">Edit Nilai Index</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="id_mahasiswa_edit{{ $nilai->id }}" class="form-label">Mahasiswa</label>
                                            <select class="form-select" id="id_mahasiswa_edit{{ $nilai->id }}" name="id_mahasiswa" required>
                                                <option value="">Pilih Mahasiswa</option>
                                                @foreach(\App\Models\Mahasiswa::all() as $mhs)
                                                    <option value="{{ $mhs->id }}" {{ $nilai->id_mahasiswa == $mhs->id ? 'selected' : '' }}>{{ $mhs->nim }} - {{ $mhs->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nilai_index_edit{{ $nilai->id }}" class="form-label">Nilai Index</label>
                                            <input type="number" step="0.01" class="form-control" id="nilai_index_edit{{ $nilai->id }}" name="nilai_index" value="{{ $nilai->nilai_index }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status_edit{{ $nilai->id }}" class="form-label">Status</label>
                                            <select class="form-select" id="status_edit{{ $nilai->id }}" name="status" required>
                                                <option value="lulus" {{ $nilai->status == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                                <option value="tidak lulus" {{ $nilai->status == 'tidak lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                                            </select>
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
                    <!-- Modal Hapus Nilai Index -->
                    <div class="modal fade" id="modalHapusNilaiIndex{{ $nilai->id }}" tabindex="-1" aria-labelledby="modalHapusNilaiIndexLabel{{ $nilai->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('nilai_index.destroy', $nilai->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalHapusNilaiIndexLabel{{ $nilai->id }}">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Yakin ingin menghapus nilai index <strong>{{ $nilai->mahasiswa->nama ?? '-' }}</strong>?</p>
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
        </div>

        <!-- Modal Tambah Nilai Index -->
        <div class="modal fade" id="modalTambahNilaiIndex" tabindex="-1" aria-labelledby="modalTambahNilaiIndexLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('nilai_index.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahNilaiIndexLabel">Tambah Nilai Index</h5>
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
                                <label for="nilai_index" class="form-label">Nilai Index</label>
                                <input type="number" step="0.01" class="form-control" id="nilai_index" name="nilai_index" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="lulus">Lulus</option>
                                    <option value="tidak lulus">Tidak Lulus</option>
                                </select>
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
