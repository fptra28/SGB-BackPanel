@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <div class="d-flex align-items-center">
        <a href="{{ route('user.index') }}" class="text-dark h3 mr-3" aria-label="Close">&times;</a>
        <span class="h3 text-gray-800">{{ __('Tambah User') }}</span>
    </div>

    <!-- Form User -->
    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data"
        class=" container bg-light px-4 py-2 rounded">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <!-- First Name -->
        <div class="form-group">
            <label class="font-weight-bolder" for=name>First Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name') }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Last Name -->
        <div class="form-group">
            <label class="font-weight-bolder" for="last_name">Last Name</label>
            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                name="last_name" value="{{ old('last_name') }}" required>
            @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="form-group">
            <label class="font-weight-bolder" for="email">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                value="{{ old('email') }}" required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Role -->
        <div class="form-group">
            <label class="font-weight-bolder" for="role">Role</label>
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
            <label class="font-weight-bolder" for="password">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password" required>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Tambah User</button>
    </form>
</div>

@endsection