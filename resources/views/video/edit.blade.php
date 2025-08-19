@extends('layouts.admin')

@section('main-content')
    <div class="d-flex align-items-center">
        <span class="h3 text-gray-800">{{ __('Edit Video') }}</span>
    </div>

    <!-- Form Edit Video -->
    <div class="container bg-gray-300 p-2 rounded">
        <form action="{{ route('video.update', $video->id) }}" method="POST" enctype="multipart/form-data" class="px-4 py-2">
            @csrf
            @method('PUT')

            <!-- Judul Video -->
            <div class="form-group">
                <label class="font-weight-bolder" for="title">Judul Video</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                    name="title" value="{{ old('title', $video->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Embed Code / Link Video -->
            <div class="form-group">
                <label class="font-weight-bolder" for="embed_code">Link Video (Embed Code / URL)</label>
                <input type="text" class="form-control @error('embed_code') is-invalid @enderror" id="embed_code"
                    name="embed_code" value="{{ old('embed_code', $video->embed_code) }}" required>
                @error('embed_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Contoh: URL YouTube atau kode &lt;iframe&gt;.</small>
            </div>

            <!-- Thumbnail Saat Ini (jika ada) -->
            @if ($video->image)
                <div class="form-group">
                    <label class="font-weight-bolder d-block">Thumbnail Saat Ini</label>
                    <img src="{{ asset($video->image) }}" alt="Thumbnail" class="img-fluid rounded mb-2"
                        style="max-height: 180px;">
                </div>
            @endif

            <!-- Upload Gambar (Opsional) -->
            <div class="form-group">
                <label class="font-weight-bolder" for="image">Ganti Thumbnail (opsional)</label>
                <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image"
                    name="image" accept="image/*">
                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <small class="text-muted d-block">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('video.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
