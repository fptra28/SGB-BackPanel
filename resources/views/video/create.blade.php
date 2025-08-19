@extends('layouts.admin')

@section('main-content')
    <div class="d-flex align-items-center">
        <span class="h3 text-gray-800">{{ __('Tambah Video') }}</span>
    </div>

    <!-- Form Video -->
    <div class="container bg-gray-300 p-2 rounded">
        <form action="{{ route('video.store') }}" method="POST" enctype="multipart/form-data" class="px-4 py-2">
            @csrf

            <!-- Judul Video -->
            <div class="form-group">
                <label class="font-weight-bolder" for="title">Judul Video</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                    name="title" value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Embed Code / Link Video -->
            <div class="form-group">
                <label class="font-weight-bolder" for="embed_code">Link Video (Embed Code / URL)</label>
                <input type="text" class="form-control @error('embed_code') is-invalid @enderror" id="embed_code"
                    name="embed_code" value="{{ old('embed_code') }}" required>
                @error('embed_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Upload Gambar (Opsional) -->
            <div class="form-group">
                <label class="font-weight-bolder" for="image">Thumbnail / Gambar (opsional)</label>
                <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image"
                    name="image" accept="image/*">
                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('video.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Tambah Video</button>
            </div>
        </form>
    </div>
@endsection
