@extends('layouts.admin', ['title' => 'List Antrian'])

@section('head')
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endsection

@section('content')
    <div class="mt-4">
        <div class="card">
            <div class="card-body">
                @if ($antrian->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Keperluan</th>
                                <th>Bukti Surat</th>
                                <th>Tanggal Terbit</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($antrian as $email)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $email->name }}</td>
                                    <td>{{ $email->email }}</td>
                                    <td>{{ $email->keperluan }}</td>
                                    <td>
                                        <a href="{{ $email->bukti_surat }}" target="_blank" rel="noopener noreferrer">
                                            Lihat dokumen
                                        </a>
                                    </td>
                                    <td>{{ $email->created_at }}</td>
                                    <td>
                                        @if ($email->status == 'menunggu')
                                            <span class="badge badge-warning">{{ $email->status }}</span>
                                        @elseif($email->status == 'diproses')
                                            <span class="badge badge-primary">{{ $email->status }}</span>
                                        @elseif($email->status == 'selesai')
                                            <span class="badge badge-success">{{ $email->status }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $email->status }}</span>
                                        @endif
                                    </td>
                                    <!-- Tambahkan ini di bagian tampilan Blade Anda, misalnya dalam loop yang menampilkan data tabel -->
                                    <td>
                                        <form action="{{ route('update.status', $email->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group my-3">
                                                <select name="status" class="form-control" onchange="this.form.submit()">
                                                    <option value="menunggu"
                                                        {{ $email->status == 'menunggu' ? 'selected' : '' }}>Menunggu
                                                    </option>
                                                    <option value="diproses"
                                                        {{ $email->status == 'diproses' ? 'selected' : '' }}>Diproses
                                                    </option>
                                                    <option value="selesai"
                                                        {{ $email->status == 'selesai' ? 'selected' : '' }}>Selesai
                                                    </option>
                                                </select>
                                            </div>
                                        </form>
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kirim ke email</th>
                                <th>Subject</th>
                                <th>Pesan</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td colspan="4" class="text-center">Belum ada catatan email terkirim</td>
                        </tbody>
                    </table>
                @endif
            </div>
            {{ $antrian->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
