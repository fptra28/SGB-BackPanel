@extends('layouts.admin')

@section('title', 'Daftar Video Edukasi')

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
        <span class="h3 text-gray-800">{{ __('Daftar Video') }}</span>

        <!-- Tombol Modal (Tampil di Mobile) -->
        <button type="button" class="btn btn-secondary d-md-none" data-toggle="modal" data-target="#filterModal">
            <i class="fas fa-filter"></i> Menu
        </button>

        <!-- Tombol Navigasi (Tampil di Desktop) -->
        <div class="d-none d-md-flex align-items-center">
            <form action="{{ route('video.index') }}" method="GET" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari video..."
                        value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <a href="{{ route('video.index') }}" class="btn btn-danger ml-2">
                <i class="fa-solid fa-rotate"></i> Reset
            </a>
            <a href="{{ route('video.create') }}" class="btn btn-primary ml-2">
                <i class="fa-solid fa-plus"></i> Tambah Video
            </a>
        </div>
    </div>

    <!-- Modal untuk Mobile -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Menu Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('video.index') }}" method="GET" class="mb-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari video..."
                                value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <a href="{{ route('video.index') }}" class="btn btn-danger btn-block mb-2">
                        <i class="fa-solid fa-rotate"></i> Reset
                    </a>
                    <a href="{{ route('video.create') }}" class="btn btn-primary btn-block">
                        <i class="fa-solid fa-plus"></i> Tambah Video
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive border rounded shadow-sm">
        <table class="table table-hover table-bordered table-striped mb-0">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Judul</th>
                    <th class="text-center">Tanggal Dibuat</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($videos as $video)
                    <tr>
                        <td class="align-middle text-center">
                            {{ $loop->iteration }}
                        </td>
                        <td class="align-middle">
                            {{ Str::limit($video->title ?? 'Judul tidak tersedia', 50) }}
                        </td>
                        <td class="align-middle text-center">
                            {{ \Carbon\Carbon::parse($video->updated_at)->translatedFormat('l, d F Y, H:i') }}
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ $video->embed_code }}" target="_blank"
                                    class="btn btn-success btn-sm text-dark mx-1 w-100">
                                    <i class="fas fa-external-link-alt"></i> Lihat
                                </a>

                                <a href="{{ route('video.edit', $video->id) }}"
                                    class="btn btn-warning btn-sm mx-1 text-dark w-100">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <form action="{{ route('video.destroy', $video->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?');"
                                    class="w-100">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1 w-100">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Tidak ada data video yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
