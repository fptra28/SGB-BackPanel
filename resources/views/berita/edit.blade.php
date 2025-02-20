@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('berita.berita') }}" class="text-dark h3 mr-3" aria-label="Close">&times;</a>
        <span class="h3 text-gray-800">{{ __('Edit Berita') }}</span>
    </div>

    <!-- Form Edit Berita -->
    @if($berita !== null)
    <form action="{{ route('berita.update', ['id' => $berita['id']]) }}" method="POST" enctype="multipart/form-data"
        class="bg-light p-4 rounded">
        @csrf
        @method('PUT')

        <!-- Upload Gambar -->
        <div class="form-group">
            <label class="mb-2">Upload Gambar</label>
            <div class="row row-cols-2 row-cols-md-5 g-3 w-100">
                @for ($i = 1; $i <= 5; $i++) <div class="col">
                    <input type="file" class="form-control @error('image' . $i) is-invalid @enderror" id="image{{ $i }}"
                        name="image{{ $i }}">
                    @if (!empty($berita['image' . $i]))
                    <img src="{{ asset('storage/uploads/berita/' . $berita['image' . $i]) }}" class="img-thumbnail mt-2"
                        width="100">
                    @endif
                    @error('image' . $i)
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
            </div>
            @endfor
        </div>
</div>

<!-- Judul Berita -->
<div class="form-group">
    <label for="Judul">Judul Berita</label>
    <input type="text" class="form-control @error('Judul') is-invalid @enderror" id="Judul" name="Judul"
        value="{{ old('Judul', optional($berita)['Judul']) }}" required>
    @error('Judul')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Isi Berita -->
<div class="form-group">
    <label for="Isi">Isi Berita</label>
    <textarea class="form-control @error('Isi') is-invalid @enderror" id="Isi"
        name="Isi">{{ old('Isi', optional($berita)['Isi']) }}</textarea>
    @error('Isi')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Author ID (Otomatis) -->
<input type="hidden" name="author_id" value="{{ Auth::id() }}">

<button type="submit" class="btn btn-primary mt-3">Perbarui Berita</button>
</form>
@else
<div class="alert alert-danger">Berita tidak ditemukan</div>
@endif
</div>

<script src="https://cdn.tiny.cloud/1/rijrac2uxn06a1q296snq7j1fi420fd29r3lc1o12yzq6fwv/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>


<script>
    tinymce.init({
    selector: '#Isi',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    height: 400,
    media_dimensions: true,
    object_resizing: "img",
    automatic_uploads: true,
    images_upload_url: '/upload-image', // Ganti dengan route untuk upload gambar
    images_upload_handler: function (blobInfo, success, failure) {
        let formData = new FormData();
        formData.append('file', blobInfo.blob());

        fetch('/upload-image', { // Ganti dengan URL endpoint backend
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.location) {
                success(data.location); // Masukkan URL gambar yang berhasil diunggah
            } else {
                failure('Gagal mengunggah gambar.');
            }
        })
        .catch(() => failure('Terjadi kesalahan saat mengunggah gambar.'));
    },
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