@extends('layouts.admin')

@section('main-content')
<div class="mb-2 d-flex justify-content-between">
    <span class="h3 text-gray-800">{{ __('Daftar Berita') }}</span>
    <a href="{{ route('berita.create') }}" class=" btn btn-primary">Tambah
        Berita</a>
</div>

<!-- Tabel untuk menampilkan data berita -->

@if (!$beritas || count($beritas) == 0)
<div class="row">
    <div class="col d-flex flex-column align-items-center justify-content-center mt-6 bg-dark p-5 rounded">
        <img src="{{ asset('img/svg/undraw_not-found_6bgl.svg') }}" alt="Not Data" height="200" class="mb-3">
        <h3 class="text-light">No Data Found</h3>
    </div>
</div>
@else
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
    @foreach ($beritas as $berita)
    <div class="col">
        <div class="card shadow h-100 d-flex flex-column">
            <img src="{{ asset('storage/uploads/berita/' . $berita['image1']) }}" class="card-img-top"
                alt="$berita['image1']" height="150" style="object-fit: cover">
            <div class="card-body d-flex flex-column flex-grow-1">
                <h5 class="card-title font-weight-bold text-dark">
                    {{ Str::limit($berita['Judul'], 50) }}
                </h5>
                <p class="card-text text-muted">
                    <i class="fas fa-user mr-2"></i>
                    <span>{{ $berita['author']['name'] ?? 'Tidak ada penulis' }}</span>
                </p>
                <p class="card-text">
                    <small class="text-gray-600">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::parse($berita['created_at'])->format('D, d F Y, h:i A') }}</span>
                    </small>
                </p>

                <!-- Spacer agar tombol selalu di bawah -->
                <div class="mt-auto">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('berita.detail', ['judul' => rawurlencode($berita['Judul'])]) }}"
                            class="btn btn-success text-dark w-100 mr-2">
                            Lihat
                        </a>
                        <a href="{{ route('berita.edit', ['id' => $berita['id']]) }}"
                            class="btn btn-warning text-dark w-100 mr-2">Edit</a>
                        <button class="btn btn-danger w-100">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif



@endsection