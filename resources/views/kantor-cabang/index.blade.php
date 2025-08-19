@extends('layouts.admin')

@section('title', 'Daftar Kantor Cabang')

@section('main-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-gray-800">Daftar Kantor Cabang</h3>
        <a href="{{ route('kantor-cabang.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kantor Cabang
        </a>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="row">
        @forelse ($kantorCabangs as $kantor)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-left-primary">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title font-weight-bold">{{ $kantor->nama_kantor_cabang }}</h5>
                        <p class="mb-1"><i class="fas fa-map-marker-alt text-danger"></i>
                            {{ $kantor->alamat_kantor_cabang }}</p>
                        <p class="mb-1"><i class="fas fa-phone text-success"></i>
                            {{ $kantor->telepon_kantor_cabang }}</p>
                        <p class="mb-1"><i class="fas fa-fax text-muted"></i>
                            {{ $kantor->fax_kantor_cabang }}</p>

                        <div class="mt-2">
                            <div class="d-flex">
                                @if ($kantor->maps_kantor_cabang)
                                    <a href="{{ $kantor->maps_kantor_cabang }}" target="_blank"
                                        class="btn btn-sm btn-success w-100">
                                        <i class="fas fa-map"></i> Lihat Peta
                                    </a>
                                @endif

                                <a href="{{ route('kantor-cabang.edit', $kantor->id) }}"
                                    class="btn btn-sm btn-warning mx-1 w-100">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('kantor-cabang.destroy', $kantor->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                    class="w-100">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">Belum ada data kantor cabang.</div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $kantorCabangs->links() }}
    </div>
@endsection
