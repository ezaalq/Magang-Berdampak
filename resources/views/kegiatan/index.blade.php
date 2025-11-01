@extends('layouts.master')

@section('title', 'Data Kegiatan')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Kegiatan</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKegiatan">
                Tambah Kegiatan
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nim</th>
                            <th>Nama Mahasiswa</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>File</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (\App\Models\Kegiatan::with('mahasiswa')->get() as $kegiatan)
                            <tr>
                                <td>{{ $kegiatan->mahasiswa->nim ?? '-' }}</td>
                                <td>{{ $kegiatan->mahasiswa->nama ?? '-' }}</td>
                                <td>{{ $kegiatan->judul }}</td>
                                <td><span class="badge bg-info">{{ ucfirst($kegiatan->kategori) }}</span></td>
                                <td>
                                    @if ($kegiatan->file_kegiatan)
                                        <a href="{{ asset('storage/' . $kegiatan->file_kegiatan) }}"
                                            target="_blank">Lihat</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                @php
                                    $statusMap = [
                                        'Menunggu' => ['label' => 'Menunggu', 'class' => 'warning'],
                                        'Disetujui' => ['label' => 'Disetujui', 'class' => 'success'],
                                        'Ditolak' => ['label' => 'Ditolak', 'class' => 'danger'],
                                    ];
                                    $s = $statusMap[$kegiatan->status] ?? [
                                        'label' => $kegiatan->status,
                                        'class' => 'secondary',
                                    ];
                                @endphp
                                <td>
                                    <span class="badge bg-{{ $s['class'] }}">{{ $s['label'] }}</span>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modalEditAbsen{{ $kegiatan->id }}">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#modalHapusAbsen{{ $kegiatan->id }}">Hapus</button>
                                </td>
                            </tr>

                            <!-- Modal Edit Kegiatan -->
                            <div class="modal fade" id="modalEditKegiatan{{ $kegiatan->id }}" tabindex="-1"
                                aria-labelledby="modalEditKegiatanLabel{{ $kegiatan->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('kegiatan.update', $kegiatan->id) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="modalEditKegiatanLabel{{ $kegiatan->id }}">Edit
                                                    Kegiatan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="id_mahasiswa_edit{{ $kegiatan->id }}"
                                                        class="form-label">Mahasiswa</label>
                                                    <select class="form-select"
                                                        id="id_mahasiswa_edit{{ $kegiatan->id }}"
                                                        name="id_mahasiswa" required>
                                                        <option value="">Pilih Mahasiswa</option>
                                                        @foreach (\App\Models\Mahasiswa::all() as $mhs)
                                                            <option value="{{ $mhs->id }}"
                                                                {{ $kegiatan->id_mahasiswa == $mhs->id ? 'selected' : '' }}>
                                                                {{ $mhs->nim }} - {{ $mhs->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="judul_edit{{ $kegiatan->id }}"
                                                        class="form-label">Judul</label>
                                                    <input type="text" class="form-control"
                                                        id="judul_edit{{ $kegiatan->id }}" name="judul"
                                                        value="{{ $kegiatan->judul }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="kategori_edit{{ $kegiatan->id }}"
                                                        class="form-label">Kategori</label>
                                                    <select class="form-select"
                                                        id="kategori_edit{{ $kegiatan->id }}" name="kategori"
                                                        required>
                                                        <option value="foto"
                                                            {{ $kegiatan->kategori == 'foto' ? 'selected' : '' }}>Foto
                                                        </option>
                                                        <option value="reels"
                                                            {{ $kegiatan->kategori == 'reels' ? 'selected' : '' }}>
                                                            Reels</option>
                                                        <option value="pressrelease"
                                                            {{ $kegiatan->kategori == 'pressrelease' ? 'selected' : '' }}>
                                                            Press Release</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="file_kegiatan_edit{{ $kegiatan->id }}"
                                                        class="form-label">File Kegiatan (opsional)</label>
                                                    <input type="file" class="form-control"
                                                        id="file_kegiatan_edit{{ $kegiatan->id }}"
                                                        name="file_kegiatan" accept="image/*,application/pdf">
                                                    @if ($kegiatan->file_kegiatan)
                                                        <small class="text-muted">File saat ini: <a
                                                                href="{{ asset('storage/' . $kegiatan->file_kegiatan) }}"
                                                                target="_blank">Lihat</a></small>
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    <label for="status_edit{{ $kegiatan->id }}"
                                                        class="form-label">Status</label>
                                                    <select class="form-select"
                                                        id="status_edit{{ $kegiatan->id }}" name="status"
                                                        required>
                                                        <option value="menunggu"
                                                            {{ $kegiatan->status == 'menunggu' ? 'selected' : '' }}>
                                                            Menunggu
                                                        </option>
                                                        <option value="disetujui"
                                                            {{ $kegiatan->status == 'disetujui' ? 'selected' : '' }}>
                                                            Disetujui</option>
                                                        <option value="ditolak"
                                                            {{ $kegiatan->status == 'ditolak' ? 'selected' : '' }}>Ditolak
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Hapus Kegiatan -->
                            <div class="modal fade" id="modalHapusKegiatan{{ $kegiatan->id }}" tabindex="-1"
                                aria-labelledby="modalHapusKegiatanLabel{{ $kegiatan->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="modalHapusKegiatanLabel{{ $kegiatan->id }}">
                                                    Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin ingin menghapus kegiatan <strong>{{ $kegiatan->judul }}</strong>
                                                    untuk <strong>{{ $kegiatan->mahasiswa->nama ?? '-' }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
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

        <!-- Modal Tambah Kegiatan -->
        <div class="modal fade" id="modalTambahKegiatan" tabindex="-1" aria-labelledby="modalTambahKegiatanLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahKegiatanLabel">Tambah Kegiatan</h5>
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
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-select" id="kategori" name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="foto">Foto</option>
                                    <option value="reels">Reels</option>
                                    <option value="pressrelease">Press Release</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="file_kegiatan" class="form-label">File Kegiatan (opsional)</label>
                                <input type="file" class="form-control" id="file_kegiatan" name="file_kegiatan"
                                    accept="image/*,application/pdf">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="menunggu">Menunggu</option>
                                    <option value="disetujui">Disetujui</option>
                                    <option value="ditolak">Ditolak</option>
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
