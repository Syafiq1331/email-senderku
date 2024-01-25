@extends('layouts.admin', ['title' => 'Bantuan'])

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{{ asset('tutor.pdf') }}" frameborder="0"></iframe>
                </div>
            </div>

        </div>
    </div>
@endsection
