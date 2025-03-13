@extends('layouts.admin')

@section('main-content')
<div class="container">
    <a href="{{ route('hero.index') }}" class="btn btn-secondary">
        ✕ Close</a>
</div>

<div class="hero-section position-relative overflow-hidden bg-light my-3">
    <div class="container">
        <div class="shadow-lg rounded bg-dark p-4 p-md-5">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                {{-- Bagian Teks --}}
                <div class="text-center text-md-left w-100 w-md-50">
                    <h1 class="display-5 font-weight-bold text-light">{{ $banner['title'] }}</h1>
                    <p class="lead text-muted">{{ $banner['description'] }}</p>
                </div>

                {{-- Bagian Gambar --}}
                <div class="text-center">
                    <img src="{{ asset('images/banners/'. $banner['image']) }}" alt="{{ $banner['title'] }}"
                        class="img-fluid" style="max-width: 400px; height: auto;">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection