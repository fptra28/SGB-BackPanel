@extends('layouts.admin')

@section('main-content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('berita.berita') }}" class="text-decoration-none">
            <h4>
                <i class="fas fa-arrow-left"></i> Back
            </h4>
        </a>
    </div>
    @if($berita && $berita['success'])
    <div class="card">
        <div class="card-header">
            <h3>{{ $berita['data']['Judul'] }}</h3>
        </div>
        <img src="{{ asset('storage/uploads/berita/' . $berita['data']['image1']) }}" class="card-img-top"
            alt="$berita['image1']" height="300" style="object-fit: cover">
        <div class="card-body">
            <p><strong>Penulis:</strong> {{ $berita['data']['author']['name'] ?? 'Tidak ada penulis' }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($berita['data']['created_at'])->format('D, d F Y, h:i
                A') }}</p>
            <p>{!! $berita['data']['Isi'] !!}</p>
        </div>
    </div>
    @else
    <div class="alert alert-danger">Berita tidak ditemukan</div>
    @endif
</div>
@endsection