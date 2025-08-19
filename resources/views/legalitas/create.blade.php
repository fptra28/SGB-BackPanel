@extends('layouts.admin')

@section('title', 'Tambah Legalitas')

@section('main-content')
    <div class="d-flex align-items-center mb-3">
        <h3 class="text-gray-800 mb-0">Tambah Legalitas</h3>
    </div>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('legalitas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="font-weight-bolder" for="title">Judul</label>
                    <input type="text" id="title" name="title"
                        class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required
                        maxlength="150">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="font-weight-bolder" for="image">Gambar (opsional)</label>
                    <input type="file" id="image" name="image"
                        class="form-control-file @error('image') is-invalid @enderror" accept="image/*"
                        onchange="previewImage(event)">
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    <div class="mt-2">
                        <img id="preview" src="#" alt="Preview" class="d-none rounded border"
                            style="max-height: 160px;">
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('legalitas.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function previewImage(e) {
            const img = document.getElementById('preview');
            const file = e.target.files && e.target.files[0];
            if (!file) {
                img.classList.add('d-none');
                img.src = '#';
                return;
            }
            const url = URL.createObjectURL(file);
            img.src = url;
            img.classList.remove('d-none');
        }
    </script>
@endsection
