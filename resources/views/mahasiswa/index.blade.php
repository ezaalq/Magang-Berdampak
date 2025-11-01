@extends('layouts.master')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Mahasiswa</h5>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahMahasiswa">
            Tambah Mahasiswa
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Asal Sekolah</th>
                        <th>Jurusan</th>
                        <th>Alamat</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\Mahasiswa::all() as $mhs)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mhs->nim }}</td>
                        <td>{{ $mhs->nama }}</td>
                        <td>{{ $mhs->email }}</td>
                        <td>{{ $mhs->asal_sekolah }}</td>
                        <td>{{ $mhs->jurusan }}</td>
                        <td>{{ $mhs->alamat }}</td>
                        <td><span class="badge bg-{{ $mhs->role == 'admin' ? 'danger' : 'info' }}">{{ ucfirst($mhs->role) }}</span></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#modalEditMahasiswa{{ $mhs->id }}">Edit</button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusMahasiswa{{ $mhs->id }}">Hapus</button>
                        </td>
                    <!-- Modal Edit Mahasiswa -->
                    <div class="modal fade" id="modalEditMahasiswa{{ $mhs->id }}" tabindex="-1" aria-labelledby="modalEditMahasiswaLabel{{ $mhs->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('mahasiswa.update', $mhs->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditMahasiswaLabel{{ $mhs->id_mahasiswa }}">Edit Mahasiswa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nim_edit{{ $mhs->id_mahasiswa }}" class="form-label">NIM</label>
                                            <input type="text" class="form-control" id="nim_edit{{ $mhs->id_mahasiswa }}" name="nim" value="{{ $mhs->nim }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama_edit{{ $mhs->id_mahasiswa }}" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama_edit{{ $mhs->id_mahasiswa }}" name="nama" value="{{ $mhs->nama }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email_edit{{ $mhs->id_mahasiswa }}" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email_edit{{ $mhs->id_mahasiswa }}" name="email" value="{{ $mhs->email }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="asal_sekolah_edit{{ $mhs->id_mahasiswa }}" class="form-label">asal sekolah</label>
                                            <input type="text" class="form-control" id="asal_sekolah_edit{{ $mhs->id_mahasiswa }}" name="asal_sekolah" value="{{ $mhs->asal_sekolah }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="jurusan_edit{{ $mhs->id_mahasiswa }}" class="form-label">Jurusan</label>
                                            <input type="text" class="form-control" id="jurusan_edit{{ $mhs->id_mahasiswa }}" name="jurusan" value="{{ $mhs->jurusan }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat_edit{{ $mhs->id_mahasiswa }}" class="form-label">Alamat</label>
                                            <input type="text" class="form-control" id="alamat_edit{{ $mhs->id_mahasiswa }}" name="alamat" value="{{ $mhs->alamat }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="foto_edit{{ $mhs->id_mahasiswa }}" class="form-label">Foto (opsional)</label>
                                            <input type="file" class="form-control" id="foto_edit{{ $mhs->id_mahasiswa }}" name="foto" accept="image/*">
                                            @if($mhs->foto)
                                                <small class="text-muted">Foto saat ini: <a href="{{ asset('storage/' . $mhs->foto) }}" target="_blank">Lihat</a></small>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label for="password_edit{{ $mhs->id_mahasiswa }}" class="form-label">Password (isi jika ingin mengubah)</label>
                                            <input type="password" class="form-control" id="password_edit{{ $mhs->id_mahasiswa }}" name="password">
                                        </div>
                                        <div class="mb-3">
                                            <label for="role_edit{{ $mhs->id_mahasiswa }}" class="form-label">Role</label>
                                            <select class="form-select" id="role_edit{{ $mhs->id_mahasiswa }}" name="role" required>
                                                <option value="mahasiswa" {{ $mhs->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                                <option value="admin" {{ $mhs->role == 'admin' ? 'selected' : '' }}>Admin</option>
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
                    <!-- Modal Hapus Mahasiswa -->
                    <div class="modal fade" id="modalHapusMahasiswa{{ $mhs->id }}" tabindex="-1" aria-labelledby="modalHapusMahasiswaLabel{{ $mhs->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('mahasiswa.destroy', $mhs->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalHapusMahasiswaLabel{{ $mhs->id_mahasiswa }}">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Yakin ingin menghapus mahasiswa <strong>{{ $mhs->nama }}</strong>?</p>
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

        <!-- Modal Tambah Mahasiswa -->
        <div class="modal fade" id="modalTambahMahasiswa" tabindex="-1" aria-labelledby="modalTambahMahasiswaLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahMahasiswaLabel">Tambah Mahasiswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" name="nim" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                                <input type="text" class="form-control" id="sekolah" name="asal_sekolah">
                            </div>
                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <input type="text" class="form-control" id="jurusan" name="jurusan">
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat">
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto (opsional)</label>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="mahasiswa">Mahasiswa</option>
                                    <option value="admin">Admin</option>
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
