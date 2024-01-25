@extends('layouts.admin', ['title' => 'Dashboard'])

@section('content')
    <div class="container mt-4">
        <h2>Email yang sudah terkirim</h2>

        @if ($emailHistory->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Kirim ke email</th>
                        <th>Subject</th>
                        <th>Pesan</th>
                        <th>Tanggal Kirim</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($emailHistory as $email)
                        <tr>
                            <td>{{ $email->email }}</td>
                            <td>{{ $email->subject }}</td>
                            <td>{{ $email->message }}</td>
                            <td>{{ $email->created_at }}</td>
                            <td>
                                <button type="submit" class="btn btn-danger" onclick="confirmDelete({{ $email->id }})">
                                    Delete
                                </button>
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

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif

    @push('scripts')
        <script>
            function confirmDelete(emailId) {
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: 'Apakah Anda yakin ingin menghapus Email History ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengonfirmasi, kirimkan permintaan penghapusan melalui AJAX atau
                        // lakukan penghapusan langsung di sini
                        deleteEmail(emailId);
                    }
                });
            }

            function deleteEmail(emailId) {
                $.ajax({
                    type: 'DELETE',
                    url: 'dashboard/' + emailId, // Sesuaikan dengan URL end-point Anda
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Email History berhasil dihapus',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Jika diperlukan, perbarui tampilan atau lakukan hal lain setelah penghapusan berhasil
                        // Misalnya, perbarui tampilan email history setelah penghapusan
                        document.location.reload(true); // atau sesuai dengan kebutuhan
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat menghapus Email History',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        console.error(xhr.responseText);
                    }
                });
            }
        </script>
    @endpush
@endsection
