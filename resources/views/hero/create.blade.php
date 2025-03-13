@extends('layouts.admin')

@section('main-content')
<div class="d-flex align-items-center justify-content-center">
    <span class="h3 text-gray-800">{{ __('Tambah Banner') }}</span>
</div>

<div class="container py-3 bg-gray-300 rounded">
    <form action="{{ route('hero.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="form-group">
            <label for="title">{{ __('Title') }}</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                value="{{ old('title') }}" required>
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description --}}
        <div class="form-group">
            <label for="description">{{ __('Description') }}</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                name="description" rows="3" required>{{ old('description') }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Image File --}}
        <div class="form-group mb-3">
            <label for="image">{{ __('Image File') }}</label>
            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image"
                required>
            @error('image')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit Button --}}
        <div class="d-flex mt-3">
            <a href="{{ route('hero.index') }}" class="btn btn-secondary w-100 mr-1">Cancel</a>
            <button type="submit" class="btn btn-primary w-100 ml-1">Submit</button>
        </div>
    </form>
</div>
@endsection