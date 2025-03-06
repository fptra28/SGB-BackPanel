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
    <span class="h3 text-gray-800">{{ __('Daftar User') }}</span>

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
        <a href="{{ route('user.index') }}" class="btn btn-danger ml-2">
            <i class="fa-solid fa-rotate"></i> Reset
        </a>
        <a href="{{ route('user.create') }}" class="btn btn-primary ml-2">
            <i class="fa-solid fa-plus"></i> Tambah User
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
                <a href="{{ route('user.index') }}" class="btn btn-danger btn-block mb-2">
                    <i class="fa-solid fa-rotate"></i> Reset
                </a>
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-block">
                    <i class="fa-solid fa-plus"></i> Tambah User
                </a>
            </div>
        </div>
    </div>
</div>

@if ($users->count() > 0)
<div class="table-responsive border rounded shadow-sm">
    <table class="table table-hover table-bordered table-striped mb-0">
        <thead class="thead-dark">
            <tr>
                <th class="align-middle text-center">#</th>
                <th class="align-middle text-center">Nama</th>
                <th class="align-middle text-center">Email</th>
                <th class="align-middle text-center">Tanggal Dibuat</th>
                <th class="align-middle text-center">Role</th>
                <th class="align-middle text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
            <tr>
                <td class="align-middle text-center">{{ $index + 1 }}</td>
                <td class="align-middle">{{ $user['name'] ?? 'Nama tidak ditemukan' }} {{ $user['last_name']
                    }}</td>
                <td class="align-middle">{{ $user['email']?? 'Email tidak ditemukan' }}</td>
                <td class="align-middle">
                    <small class="text-muted">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        {{ \Carbon\Carbon::parse($user['created_at'] ?? now())->format('D, d F Y, h:i A') }}
                    </small>
                </td>
                <td class="align-middle text-center text-capitalize">
                    @if ($user['role'] == 'superadmin')
                    <span class="badge badge-success text-dark">Superadmin</span>
                    @else
                    <span class="badge badge-info text-dark">Admin</span>
                    @endif
                </td>
                <td class="align-middle text-center">
                    <div class="d-flex flex-row w-100">
                        <a href="{{ route('user.edit', ['id' => $user['id'] ?? 0]) }}"
                            class="btn btn-warning btn-sm w-100 mx-1 text-dark">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('user.destroy', ['id' => $user['id']]) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');"
                            class="w-100 ml-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<!-- Tampilkan Pesan Jika Data Tidak Ditemukan -->
<div class="alert alert-warning text-center mt-4">
    <i class="fas fa-exclamation-triangle mr-2"></i><span>Data berita tidak ditemukan.</span>
</div>
@endif


@endsection