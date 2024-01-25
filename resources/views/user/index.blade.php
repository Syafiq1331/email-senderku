@extends('layouts.user', ['title' => 'Daftar Antrian'])

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Daftar Peng-antrian Online</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('daftar-antrian') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="text" class="form-label text-primary">Nama Pendaftar :</label>
                            <input type="text" class="form-control @error('text') is-invalid @enderror" id="text"
                                name="text" placeholder="Muhammad Udin" value="{{ old('text') }}">
                            @error('text')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label text-primary">Email Pendaftar :</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="mhdudin@gmail.com">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="fileSurat" class="form-label text-primary">Surat Persyaratan :</label>
                            <input type="file" class="form-control @error('fileSurat') is-invalid @enderror"
                                id="fileSurat" name="fileSurat" onchange="previewFile()">
                            @error('fileSurat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="keperluan" class="form-label text-primary">Keperluan :</label>
                            <select class="form-control @error('keperluan') is-invalid @enderror" id="keperluan"
                                name="keperluan">
                                <option value="" selected disabled>Pilih Keperluan</option>
                                <option value="opsi1" {{ old('keperluan') == 'opsi1' ? 'selected' : '' }}>Opsi 1</option>
                                <option value="opsi2" {{ old('keperluan') == 'opsi2' ? 'selected' : '' }}>Opsi 2</option>
                                <option value="opsi3" {{ old('keperluan') == 'opsi3' ? 'selected' : '' }}>Opsi 3</option>
                                <!-- Tambahkan opsi sesuai dengan keperluan Anda -->
                            </select>
                            @error('keperluan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <label for="fileSurat" class="form-label text-primary">Preview Surat Persyaratan :</label>
                        <div id="previewContainer" class="text-primary"><strong>
                                Belum ada dokumen surat yang diunggah
                            </strong>
                        </div>
                    </div>

                </div>
                <div class="mb-3 mt-5 w-100">
                    <input type="submit" class="btn btn-primary w-100" value="Daftar Antrian">
                </div>
            </form>
        </div>
    </div>

    {{-- Tambahkan di bagian atas file daftar-antrian.blade.php --}}
    @if (Session::has('success'))
        <script>
            Swal.fire({
                title: 'Terima kasih!',
                text: '{{ Session::get('success') }}',
                icon: 'success',
                showConfirmButton: true,
            });
        </script>
    @endif
    {{-- Akhir tambahan --}}
@endsection
