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

@if ($videos->count() > 0)

<!-- Form Bulk Delete membungkus tabel -->
<form action="{{ route('video.bulkDelete') }}" method="POST" id="bulkDeleteForm"
    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data yang dipilih?');">
    @csrf

    <button type="submit" class="btn btn-danger mb-3" id="bulkDeleteBtn" disabled>
        <i class="fas fa-trash-alt"></i> Hapus Terpilih
    </button>

    <div class="table-responsive border rounded shadow-sm">
        <table class="table table-hover table-bordered table-striped mb-0">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th class="text-center">Judul</th>
                    <th class="text-center">Tanggal Dibuat</th>
                    <th class="text-center">Link</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($videos as $index => $video)
                <tr>
                    <td class="align-middle text-center">
                        <input type="checkbox" name="delete_ids[]" value="{{ $video['id'] }}" class="delete-checkbox">
                    </td>
                    <td class="align-middle">{{ Str::limit($video['title'] ?? 'Judul tidak tersedia', 100) }}</td>
                    <td class="align-middle text-center">
                        {{ \Carbon\Carbon::parse($video['created_at'] ?? now())->format('D, d F Y, h:i A') }}
                    </td>
                    <td class="align-middle text-center">
                        {{ Str::limit($video['video_links'] ?? 'Judul tidak tersedia', 30) }}
                    </td>
                    <td class="align-middle text-center">
                        <div class="d-flex flex-row w-100">
                            <a href="{{ $video['video_links'] }}" target="_blank"
                                class="btn btn-success btn-sm mr-1 w-100">
                                <i class="fas fa-external-link-alt"></i> Lihat
                            </a>
                            <a href="{{ route('video.edit', ['id' => $video['id'] ?? 0]) }}"
                                class="btn btn-warning btn-sm w-100 mx-1 text-dark">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('video.destroy', ['id' => $video['id']]) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?');"
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
</form>

<div class="d-flex justify-content-center mt-5">
    {{ $videos->links() }}
</div>

@else
<!-- Tampilkan Pesan Jika Data Tidak Ditemukan -->
<div class="alert alert-warning text-center mt-4">
    <i class="fas fa-exclamation-triangle mr-2"></i><span>Data video tidak ditemukan.</span>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.delete-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const selectAll = document.getElementById('selectAll');

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            bulkDeleteBtn.disabled = !Array.from(checkboxes).some(c => c.checked);
        });
    });

    selectAll.addEventListener('change', function () {
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
        bulkDeleteBtn.disabled = !selectAll.checked;
    });
});
</script>

@endsection