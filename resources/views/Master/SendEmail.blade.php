@extends('layouts.admin', ['title' => 'Sender Email'])

@section('head')
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('send-email') }}" method="post" id="email-form">
                    @csrf
                    <div class="mb-3">
                        <label for="emails" class="form-label">Email Tujuan :</label>
                        <div id="email-container">
                            <!-- Container for displaying added emails -->
                        </div>
                        <select class="form-control h-25 @error('emails') is-invalid @enderror" id="emailDropdown"
                            name="emails[]" required multiple>
                            @foreach ($getEmails as $email)
                                <option value="{{ $email }}"
                                    {{ in_array($email, old('emails', [])) ? 'selected' : '' }}>
                                    {{ $email }}
                                </option>
                            @endforeach
                        </select>
                        @error('emails')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <button type="button" class="mt-3 btn btn-success" id="add-email-btn">Add Email</button>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject :</label>
                        <input type="text" class="form-control" name="subject" required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Isi Pesan :</label>
                        <textarea class="form-control" name="message" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Kirim Email</button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('add-email-btn').addEventListener('click', function() {
                    var selectedEmails = Array.from(document.getElementById('emailDropdown').selectedOptions)
                        .map(option => option.value);

                    if (selectedEmails && selectedEmails.length > 0) {
                        selectedEmails.forEach(function(email) {
                            // Check if email is already added
                            if (!document.getElementById('email-container').innerText.includes(email)) {
                                // Add the new email to the container
                                var emailDiv = document.createElement('div');
                                emailDiv.className = 'btn btn-info mb-2 mx-2';
                                emailDiv.innerText = email;
                                document.getElementById('email-container').appendChild(emailDiv);
                            } else {
                                // Show alert if email is already added
                                alert('Email sudah ditambahkan.');
                            }
                        });
                    } else {
                        // Show error message if no email is selected
                        alert('Pilih setidaknya satu email.');
                    }
                });

                document.getElementById('email-form').addEventListener('submit', function(event) {
                    // Remove existing hidden input field for emails
                    var existingInput = document.getElementById('hidden-emails');
                    if (existingInput) {
                        existingInput.remove();
                    }

                    // Create a hidden input field for emails
                    var selectedEmails = Array.from(document.getElementById('email-container').children)
                        .map(emailDiv => emailDiv.innerText.trim())
                        .join(',');

                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'emails';
                    input.id = 'hidden-emails';
                    input.value = selectedEmails;
                    document.getElementById('email-form').appendChild(input);
                });
            });
        </script>
    @endpush
@endsection
