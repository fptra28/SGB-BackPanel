@extends('layouts.admin')

@section('main-content')
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@elseif(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="mb-2 d-flex justify-content-between align-items-center">
    <span class="h3 text-gray-800">{{ __('Daftar User') }}</span>

    <!-- Tombol Modal (Tampil di Mobile) -->
    <button type="button" class="btn btn-secondary d-md-none" data-toggle="modal" data-target="#filterModal">
        <i class="fas fa-filter"></i> Menu
    </button>

    <!-- Tombol Navigasi (Tampil di Desktop) -->
    <div class="d-none d-md-flex align-items-center">
        <form action="{{ route('user.index') }}" method="GET" class="form-inline">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari User..."
                    value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">Cari</button>
                </div>
            </div>
        </form>
        <a href="{{ route('user.index') }}" class="btn btn-danger ml-2">Reset</a>
        <a href="{{ route('user.create') }}" class="btn btn-primary ml-2">Tambah User</a>
    </div>
</div>

<!-- Modal untuk Mobile -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Menu User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('berita.berita') }}" method="GET" class="mb-2">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari User..."
                            value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Cari</button>
                        </div>
                    </div>
                </form>
                <a href="{{ route('user.index') }}" class="btn btn-danger btn-block mb-2">Reset</a>
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-block">Tambah User</a>
            </div>
        </div>
    </div>
</div>

@if ($users->count() > 0)
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
    @foreach ($users as $user)
    <div class="col mb-3">
        <div class="card shadow h-100 d-flex flex-column">
            <div class="card-body d-flex flex-column h-100">
                <h5 class="card-title font-weight-bold text-dark">
                    {{ $user['name'] ?? 'Nama tidak ditemukan' }} {{ $user['last_name'] }}
                </h5>

                <div class="mb-3">
                    <p class="card-text">
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            {{ \Carbon\Carbon::parse($user['created_at'] ?? now())->format('D, d F Y, h:i A') }}
                        </small>
                    </p>
                </div>

                <div class="d-flex mt-auto">
                    <a href="{{ route('berita.edit', ['id' => $user['id'] ?? 0]) }}"
                        class="btn btn-warning text-dark flex-grow-1 mx-1">Edit</a>
                    @if (!empty($user['id']))
                    <form action="{{ route('berita.destroy', ['id' => $user['id']]) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');"
                        class="flex-grow-1 mx-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">Hapus</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@else
<!-- Tampilkan Pesan Jika Data Tidak Ditemukan -->
<div class="alert alert-warning text-center mt-4">
    <i class="fas fa-exclamation-triangle mr-2"></i><span>Data berita tidak ditemukan.</span>
</div>
@endif

@endsection