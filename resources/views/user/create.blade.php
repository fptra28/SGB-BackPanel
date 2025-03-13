@extends('layouts.admin')

@section('main-content')
<div class="d-flex align-items-center justify-content-center">
    <span class="h3 text-gray-800">{{ __('Tambah User') }}</span>
</div>

<!-- Form User -->
<form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data"
    class="container bg-gray-300 p-4 rounded mt-3">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <!-- First Name -->
    <div class="form-group">
        <label class="font-weight-bolder" for=name>First Name<span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            value="{{ old('name') }}" required>
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Last Name -->
    <div class="form-group">
        <label class="font-weight-bolder" for="last_name">Last Name</label>
        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name"
            value="{{ old('last_name') }}">
        @error('last_name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div class="form-group">
        <label class="font-weight-bolder" for="email">Email<span class="text-danger">*</span></label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
            value="{{ old('email') }}" required>
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Role -->
    <div class="form-group">
        <label class="font-weight-bolder" for="role">Role<span class="text-danger">*</span></label>
        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
            <option value="">Pilih Role</option>
            <option value="superadmin">Superadmin</option>
            <option value="admin">Admin</option>
        </select>
        @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="form-group">
        <label class="font-weight-bolder" for="password">Password<span class="text-danger">*</span></label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
            name="password" required>
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-between mt-3 w-100">
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>

        <button type="submit" class="btn btn-primary">Tambah User</button>
    </div>
</form>

@endsection