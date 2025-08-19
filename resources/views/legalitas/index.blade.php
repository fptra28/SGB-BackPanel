@extends('layouts.admin')

@section('title', 'Daftar Legalitas')

@section('main-content')
    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-gray-800 mb-0">Daftar Legalitas</h3>

        <div class="d-flex">
            <form action="{{ route('legalitas.index') }}" method="GET" class="form-inline mr-2">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari judul..."
                        value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <a href="{{ route('legalitas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>
    </div>

    <div class="table-responsive border rounded shadow-sm">
        <table class="table table-hover table-bordered table-striped mb-0">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" style="width:60px">#</th>
                    <th style="width:120px">Gambar</th>
                    <th>Judul</th>
                    <th class="text-center" style="width:180px">Dibuat</th>
                    <th class="text-center" style="width:170px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($legalitasList as $item)
                    <tr>
                        <td class="align-middle text-center">
                            {{ $loop->iteration + ($legalitasList->currentPage() - 1) * $legalitasList->perPage() }}
                        </td>
                        <td class="align-middle">
                            @if ($item->image)
                                <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" class="img-fluid rounded"
                                    style="max-height:80px">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            {{ $item->title }}
                        </td>
                        <td class="align-middle text-center">
                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y H:i') }}
                        </td>
                        <td class="align-middle text-center">
                            <a href="{{ route('legalitas.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('legalitas.destroy', $item->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada data legalitas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3 d-flex justify-content-end">
        {{ $legalitasList->links() }}
    </div>
@endsection
