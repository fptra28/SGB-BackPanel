@extends('layouts.admin')

@section('title', $produk->nama_produk)

@section('main-content')
    <div class="card shadow">
        <div class="card-header py-3">
            <div class="d-flex align-items-center">
                {{-- Tombol kembali ke daftar produk --}}
                <a href="{{ route('produk.index') }}" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <h3 class="m-0 font-weight-bold ml-3">
                    {{ $produk->nama_produk }}
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Gambar Produk --}}
                <div class="col-md-4">
                    @if ($produk->image)
                        <img src="{{ asset($produk->image) }}" alt="{{ $produk->nama_produk }}"
                            class="img-fluid rounded shadow">
                    @else
                        <img src="{{ asset('assets/no-image.png') }}" alt="No Image" class="img-fluid rounded shadow">
                    @endif
                </div>

                {{-- Detail Produk --}}
                <div class="col-md-8">
                    <div>
                        <div>
                            <h5 class="font-weight-bold">- Deskripsi -</h5>
                            <p>
                                {{ $produk->deskripsi_produk }}
                            </p>
                        </div>
                        <div>
                            <h5 class="font-weight-bold">- Spesifikasi -</h5>
                            {!! $produk->specs !!}
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning btn-sm">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>

                        <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
