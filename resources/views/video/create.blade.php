@extends('layouts.admin')

@section('main-content')
<div class="d-flex align-items-center">
    <span class="h3 text-gray-800">{{ __('Tambah Video') }}</span>
</div>

<!-- Form Berita -->
<div class="container bg-gray-300 p-2 rounded">
    <form action="{{ route('video.store') }}" method="POST" enctype="multipart/form-data" class="px-4 py-2">
        @csrf

        <!-- Judul Video -->
        <div class="form-group">
            <label class="font-weight-bolder" for="title">Judul Video</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                value="{{ old('video_links') }}" required>
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Link Video -->
        <div class="form-group">
            <label class="font-weight-bolder" for="Judul">Link Video (Embed)</label>
            <input type="text" class="form-control @error('video_links') is-invalid @enderror" id="video_links"
                name="video_links" value="{{ old('video_links') }}" required>
            @error('video_links')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between mt-3">
            <a href="{{ route('video.index') }}" class="btn btn-secondary">Cancel</a>

            <button type="submit" class="btn btn-primary">Tambah Video</button>
        </div>
    </form>
</div>

@endsection