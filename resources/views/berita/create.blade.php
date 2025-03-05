@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <div class="d-flex align-items-center">
        <a href="{{ route('berita.berita') }}" class="text-dark h3 mr-3" aria-label="Close">&times;</a>
        <span class="h3 text-gray-800">{{ __('Tambah Berita') }}</span>
    </div>

    <!-- Form Berita -->
    <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data"
        class="bg-light px-4 py-2 rounded">
        @csrf

        <!-- Upload Gambar -->
        <div class="form-group">
            <label class="font-weight-bolder" for="image1">Upload Gambar</label>
            <input type="file" class="form-control @error('image1') is-invalid @enderror" id="image1" name="image1">
            @error('image1')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Judul Berita -->
        <div class="form-group">
            <label class="font-weight-bolder" for="Judul">Judul Berita</label>
            <input type="text" class="form-control @error('Judul') is-invalid @enderror" id="Judul" name="Judul"
                value="{{ old('Judul') }}" required>
            @error('Judul')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Isi Berita -->
        <div class="form-group">
            <label class="font-weight-bolder" for="Isi">Isi Berita</label>
            <div class="shadow border rounded-lg">
                <textarea class="form-control @error('Isi') is-invalid @enderror" id="Isi"
                    name="Isi">{{ old('Isi') }}</textarea>
            </div>
            @error('Isi')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Author ID (Otomatis) -->
        <input type="hidden" name="author_id" value="{{ Auth::id() }}">

        <button type="submit" class="btn btn-primary mt-3">Tambah Berita</button>
    </form>
</div>

<!-- TinyMCE Integration -->
<script src="https://cdn.tiny.cloud/1/rijrac2uxn06a1q296snq7j1fi420fd29r3lc1o12yzq6fwv/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>

<script>
    tinymce.init({
    selector: '#Isi',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    height: 450,
    media_dimensions: true,
    object_resizing: "img",
    automatic_uploads: true,
    image_class_list: [
        { title: 'Responsive', value: 'img-fluid' }
    ],
    content_style: `
        .img-fluid { 
            max-width: 100%; 
            height: auto; 
        }
        .mediaembed { 
            max-width: 100%; 
            height: auto; 
        }
    `
});

</script>

@endsection