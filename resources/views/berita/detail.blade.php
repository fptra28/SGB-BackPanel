@extends('layouts.admin')

@section('main-content')
<div class="container">
    <div class="mb-3 d-flex align-items-center justify-content-between">
        <a href="{{ route('berita.berita') }}" class="text-decoration-none">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <a href="{{ route('berita.edit', ['id' => $berita['data']['id']]) }}" class="btn btn-warning text-dark">Edit
            Berita</a>
    </div>
    @if($berita && $berita['success'])
    <div class="card">
        <div class="card-header">
            <h3 class="font-weight-bolder">{{ $berita['data']['Judul'] }}</h3>
        </div>
        <img src="{{ asset('images/berita/' . $berita['data']['image1']) }}" class="card-img-top"
            alt="$berita['image1']" height="300" style="object-fit: cover">
        <div class="card-body">
            <div class="m-0 d-flex flex-column flex-lg-row">
                <p class="m-0 font-weight-bold">
                    {{ $berita['data']['author']['name'] ?? 'Tidak ada penulis' }}
                    {{ $berita['data']['author']['last_name'] }}
                </p>
                <span class="mx-3 d-none d-lg-flex">|</span>
                <p class="m-0">
                    {{ \Carbon\Carbon::parse($berita['data']['created_at'])->translatedFormat('l, d F Y, H:i') }}
            </div>
            <p>{!! $berita['data']['Isi'] !!}</p>
        </div>
    </div>
    @else
    <div class="alert alert-danger">Berita tidak ditemukan</div>
    @endif
</div>
@endsection