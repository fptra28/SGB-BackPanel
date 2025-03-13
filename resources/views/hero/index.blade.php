@extends('layouts.admin')

@section('main-content')
@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="mb-2 d-flex justify-content-between align-items-center">
    <span class="h3 text-gray-800">{{ __('Daftar Banner') }}</span>

    <!-- Tombol Modal (Tampil di Mobile) -->
    <button type="button" class="btn btn-secondary d-md-none" data-toggle="modal" data-target="#filterModal">
        <i class="fas fa-filter"></i> Menu
    </button>

    <!-- Tombol Navigasi (Tampil di Desktop) -->
    <div class="d-none d-md-flex align-items-center">
        <form action="" method="GET" class="form-inline">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari User..."
                    value="{{ request('search') }}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <a href="{{ route('hero.index') }}" class="btn btn-danger ml-2">
            <i class="fa-solid fa-rotate"></i> Reset
        </a>
        <a href="{{ route('hero.create') }}" class="btn btn-primary ml-2">
            <i class="fa-solid fa-plus"></i> Tambah Banner
        </a>
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
                <form action="" method="GET" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari User..."
                            value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <a href="{{ route('hero.index') }}" class="btn btn-danger btn-block mb-2">
                    <i class="fa-solid fa-rotate"></i> Reset
                </a>
                <a href="{{ route('hero.create') }}" class="btn btn-primary btn-block">
                    <i class="fa-solid fa-plus"></i> Tambah Banner
                </a>
            </div>
        </div>
    </div>
</div>

@if ($banners -> count() > 0)
<div class="table-responsive border rounded shadow-sm">
    <table class="table table-hover table-bordered table-striped mb-0">
        <thead class="thead-dark">
            <tr>
                <th class="align-middle text-center">#</th>
                <th class="align-middle text-center">Judul</th>
                <th class="align-middle text-center">Deskripsi</th>
                <th class="align-middle text-center">Banner Image</th>
                <th class="align-middle text-center">Tanggal Dibuat</th>
                <th class="align-middle text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banners as $index => $banner)
            <tr>
                <td class="align-middle text-center">{{ $index + 1 }}</td>
                <td class="align-middle">{{ $banner['title'] }}</td>
                <td class="align-middle">{{ Str::limit($banner['description'] ?? 'Deskripsi tidak tersedia', 75) }}</td>
                <td class="align-middle">
                    {{$banner['image']}}
                </td>
                <td class="align-middle text-center">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    {{ \Carbon\Carbon::parse($banner['created_at'] ?? now())->format('D, d F Y, h:i A') }}
                </td>
                <td class="d-flex">
                    <a href="{{ route('hero.show', $banner['id']) }}"
                        class="btn btn-success btn-sm text-dark flex-grow-1 mr-1">Detail</a>
                    <a href="{{ route('hero.edit', $banner['id']) }}"
                        class="btn btn-warning btn-sm text-dark flex-grow-1 mx-1">Edit</a>

                    <!-- Tombol Hapus -->
                    <button type="button" class="btn btn-danger btn-sm flex-grow-1 ml-1" data-toggle="modal"
                        data-target="#deleteModal{{ $banner['id'] }}">
                        Delete
                    </button>

                    <!-- Modal Konfirmasi Hapus -->
                    <div class="modal fade" id="deleteModal{{ $banner['id'] }}" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel{{ $banner['id'] }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $banner['id'] }}">Konfirmasi Hapus
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus banner <strong>{{ $banner['title'] }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <form action="{{ route('hero.destroy', $banner['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="alert alert-warning text-center mt-4">
    <i class="fas fa-exclamation-triangle mr-2"></i><span>Tidak ada data banner ditemukan.</span>
</div>
@endif

@endsection