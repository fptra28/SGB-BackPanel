@extends('layouts.admin')

@section('main-content')
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@elseif(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="mb-2 d-flex justify-content-between">
    <span class="h3 text-gray-800">{{ __('Daftar Berita') }}</span>
    <a href="{{ route('berita.create') }}" class="btn btn-primary">Tambah Berita</a>
</div>

@if (!$beritas || count($beritas) == 0)
<div class="row">
    <div class="col d-flex flex-column align-items-center justify-content-center mt-6 bg-dark p-5 rounded">
        <img src="{{ asset('img/svg/undraw_not-found_6bgl.svg') }}" alt="Not Data" height="200" class="mb-3">
        <h3 class="text-light">No Data Found</h3>
    </div>
</div>
@else
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
    @foreach ($beritas as $berita)
    <div class="col mb-3">
        <div class="card shadow h-100 d-flex flex-column">
            <img src="{{ asset('storage/uploads/berita/' . $berita['image1']) }}" class="card-img-top"
                alt="{{ $berita['image1'] }}" height="150" style="object-fit: cover">
            <div class="card-body d-flex flex-column flex-grow-1">
                <h5 class="card-title font-weight-bold text-dark">
                    {{ Str::limit($berita['Judul'], 50) }}
                </h5>
                <p class="card-text text-muted">
                    <i class="fas fa-user mr-2"></i>
                    <span>{{ $berita['author']['name'] ?? 'Tidak ada penulis' }}</span>
                </p>
                <p class="card-text">
                    <small class="text-gray-600">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::parse($berita['created_at'])->format('D, d F Y, h:i A') }}</span>
                    </small>
                </p>

                <!-- Spacer agar tombol selalu di bawah -->
                <div class="mt-auto">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('berita.detail', ['judul' => rawurlencode($berita['Judul'])]) }}"
                            class="btn btn-success text-dark w-100 mr-2">
                            Lihat
                        </a>
                        <a href="{{ route('berita.edit', ['id' => $berita['id']]) }}"
                            class="btn btn-warning text-dark w-100 mr-2">Edit</a>
                        <button class="btn btn-danger w-100 btn-delete" data-id="{{ $berita['id'] }}"
                            data-title="{{ $berita['Judul'] }}" data-token="{{ csrf_token() }}" data-toggle="modal"
                            data-target="#deleteModal">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus berita <strong id="deleteTitle"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
    $('.btn-delete').on('click', function () {
        let id = $(this).data('id');
        let title = $(this).data('title');

        $('#deleteTitle').text(title);
        $('#confirmDelete').data('id', id);
    });

    $('#confirmDelete').on('click', function () {
        let id = $(this).data('id');
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "/berita/delete/" + id,
            type: "DELETE",
            data: { _token: csrfToken },
            success: function (response) {
                $('#deleteModal').modal('hide'); // Tutup modal setelah sukses
                location.reload();
            },
            error: function (xhr) {
                alert("Gagal menghapus berita!");
            }
        });
    });
});
</script>
@endpush