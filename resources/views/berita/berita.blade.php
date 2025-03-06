@extends('layouts.admin')

@section('main-content')
@if(session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@elseif(session('error'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Bagian Header -->
<div class="mb-2 d-flex justify-content-between align-items-center">
    <span class="h3 text-gray-800">{{ __('Daftar Berita') }}</span>

    <!-- Tombol Modal (Tampil di Mobile) -->
    <button type="button" class="btn btn-secondary d-md-none" data-toggle="modal" data-target="#filterModal">
        <i class="fas fa-filter"></i> Menu
    </button>

    <!-- Tombol Navigasi (Tampil di Desktop) -->
    <div class="d-none d-md-flex align-items-center">
        <form action="{{ route('berita.berita') }}" method="GET" class="form-inline">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari berita..."
                    value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <a href="{{ route('berita.berita') }}" class="btn btn-danger ml-2">
            <i class="fa-solid fa-rotate"></i> Reset
        </a>
        <a href="{{ route('berita.create') }}" class="btn btn-primary ml-2">
            <i class="fa-solid fa-plus"></i> Tambah Berita
        </a>
    </div>
</div>

<!-- Modal untuk Mobile -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Menu Berita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('berita.berita') }}" method="GET" class="mb-2">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari berita..."
                            value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <a href="{{ route('berita.berita') }}" class="btn btn-danger btn-block mb-2">
                    <i class="fa-solid fa-rotate"></i> Reset
                </a>
                <a href="{{ route('berita.create') }}" class="btn btn-primary btn-block">
                    <i class="fa-solid fa-plus"></i> Tambah Berita
                </a>
            </div>
        </div>
    </div>
</div>

@if ($beritas->count() > 0)
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
    @foreach ($beritas as $berita)
    <div class="col mb-3">
        <div class="card shadow h-100 d-flex flex-column">
            <img src="{{ !empty($berita['image1']) ? asset('storage/uploads/' . $berita['image1']) : 'https://placehold.co/600x400' }}"
                class="card-img-top" height="150" style="object-fit: cover;">

            <div class="card-body d-flex flex-column h-100">
                <h5 class="card-title font-weight-bold text-dark">
                    {{ Str::limit($berita['Judul'] ?? 'Judul tidak tersedia', 50) }}
                </h5>

                <div class="mb-3">
                    <p class="card-text text-muted mb-1">
                        <i class="fas fa-user mr-2"></i>
                        {{ $berita['author']['name'] ?? 'Tidak ada penulis' }}
                        {{ $berita['author']['last_name'] ?? 'Tidak ada penulis' }}
                    </p>
                    <p class="card-text">
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            {{ \Carbon\Carbon::parse($berita['created_at'] ?? now())->format('D, d F Y, h:i A') }}
                        </small>
                    </p>
                </div>

                <div class="mt-auto">
                    <div class="row no-gutters">
                        <div class="col-4 pr-1">
                            <a href="{{ route('berita.detail', ['judul' => rawurlencode($berita['Judul'] ?? '')]) }}"
                                class="btn btn-success btn-block text-dark">Lihat</a>
                        </div>
                        <div class="col-4 px-1">
                            <a href="{{ route('berita.edit', ['id' => $berita['id'] ?? 0]) }}"
                                class="btn btn-warning btn-block text-dark">Edit</a>
                        </div>
                        @if (!empty($berita['id']))
                        <form action="{{ route('berita.destroy', ['id' => $berita['id']]) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');"
                            class="col-4 px-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block text-delete">Hapus</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Tambahkan Pagination -->
<div class="d-flex justify-content-center mt-3">
    {{ $beritas->links() }}
</div>

@else
<!-- Tampilkan Pesan Jika Data Tidak Ditemukan -->
<div class="alert alert-warning text-center mt-4">
    <i class="fas fa-exclamation-triangle mr-2"></i><span>Data berita tidak ditemukan.</span>
</div>
@endif

@endsection