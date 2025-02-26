@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <div class="d-flex align-items-center">
        <a href="{{ route('video.index') }}" class="text-dark h3 mr-3" aria-label="Close">&times;</a>
        <span class="h3 text-gray-800">{{ __('Tambah Video') }}</span>
    </div>

    <!-- Form Berita -->
    <div class="container bg-white p-2 rounded">
        <form action="{{ route('video.update', ['id' => $video['id']]) }}" method="POST" enctype="multipart/form-data"
            class="px-4 py-2">
            @csrf
            @method('PUT')

            <!-- Judul Video -->
            <div class="form-group">
                <label class="font-weight-bolder" for="title">Judul Video</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    value="{{ old('title', optional($video)['title']) }}" required>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Link Video -->
            <div class="form-group">
                <label class="font-weight-bolder" for="Judul">Link Video</label>
                <input type="text" class="form-control @error('video_links') is-invalid @enderror" id="video_links"
                    name="video_links" value="{{ old('video_links', optional($video)['video_links']) }}" required>
                @error('video_links')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Tambah Video</button>
        </form>
    </div>
</div>

@endsection