@extends('layouts.admin')

@section('title', $kantorCabang->nama_kantor_cabang)

@section('main-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-gray-800">Edit Kantor Cabang</h3>
        <a href="{{ route('kantor-cabang.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('kantor-cabang.update', $kantorCabang->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama Kantor -->
                <div class="form-group">
                    <label for="nama_kantor_cabang" class="font-weight-bold">Nama Kantor</label>
                    <input type="text" class="form-control @error('nama_kantor_cabang') is-invalid @enderror"
                        id="nama_kantor_cabang" name="nama_kantor_cabang"
                        value="{{ old('nama_kantor_cabang', $kantorCabang->nama_kantor_cabang) }}" required>
                    @error('nama_kantor_cabang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label for="alamat_kantor_cabang" class="font-weight-bold">Alamat</label>
                    <textarea class="form-control @error('alamat_kantor_cabang') is-invalid @enderror" id="alamat_kantor_cabang"
                        name="alamat_kantor_cabang" rows="3" required>{{ old('alamat_kantor_cabang', $kantorCabang->alamat_kantor_cabang) }}</textarea>
                    @error('alamat_kantor_cabang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Telepon -->
                <div class="form-group">
                    <label for="telepon_kantor_cabang" class="font-weight-bold">Telepon</label>
                    <input type="text" class="form-control @error('telepon_kantor_cabang') is-invalid @enderror"
                        id="telepon_kantor_cabang" name="telepon_kantor_cabang"
                        value="{{ old('telepon_kantor_cabang', $kantorCabang->telepon_kantor_cabang) }}" required>
                    @error('telepon_kantor_cabang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Fax -->
                <div class="form-group">
                    <label for="fax_kantor_cabang" class="font-weight-bold">Fax</label>
                    <input type="text" class="form-control @error('fax_kantor_cabang') is-invalid @enderror"
                        id="fax_kantor_cabang" name="fax_kantor_cabang"
                        value="{{ old('fax_kantor_cabang', $kantorCabang->fax_kantor_cabang) }}" required>
                    @error('fax_kantor_cabang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Maps -->
                <div class="form-group">
                    <label for="maps_kantor_cabang" class="font-weight-bold">Google Maps (URL/embed)</label>
                    <textarea class="form-control @error('maps_kantor_cabang') is-invalid @enderror" id="maps_kantor_cabang"
                        name="maps_kantor_cabang" rows="3" required>{{ old('maps_kantor_cabang', $kantorCabang->maps_kantor_cabang) }}</textarea>
                    @error('maps_kantor_cabang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('kantor-cabang.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
