@extends('layouts.admin')


@section('main-content') <div class="mb-3 d-flex justify-content-between align-items-center">
    <h1 class="h3 text-gray-800">{{ __('Daftar Berita') }}</h1>
    <button class="btn btn-primary">Tambah Berita</button>
</div>

<!-- Tabel untuk menampilkan data berita -->
<table class="table table-dark table-hover table-striped rounded">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Judul</th>
            <th class="text-center">Penulis</th>
            <th class="text-center">Isi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($beritas as $berita)
        <tr>
            <td class="text-center align-middle">{{ $loop->iteration }}</td>
            <td class="text-center align-middle">{{ $berita['Judul'] }}</td>
            <td class="text-center align-middle">{{ $berita['author']['name'] ?? 'Tidak ada penulis' }}</td>
            <td class="text-center align-middle">{{ Str::limit($berita['Isi'], 100) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection