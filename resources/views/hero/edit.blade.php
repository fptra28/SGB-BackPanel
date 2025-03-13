@extends('layouts.admin')

@section('main-content')
<div class="d-flex align-items-center justify-content-center mb-4">
    <h3 class="text-gray-800 font-weight-bold">{{ __('Edit Banner') }}</h3>
</div>

<div class="container p-4 bg-gray-200 border shadow-lg rounded">
    <form action="{{ route('hero.update', ['id' => $banner['id']]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="form-group">
            <label for="title">{{ __('Title') }}<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                value="{{ old('title', $banner['title']) }}" required>
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description --}}
        <div class="form-group">
            <label for="description">{{ __('Description') }}<span class="text-danger">*</span></label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                name="description" rows="3" required>{{ old('description', $banner['description']) }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Image File --}}
        <div class="form-group">
            <label for="image">{{ __('Image File') }} <span class="text-muted">(Opsional)</span></label>
            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
            @error('image')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Preview Image --}}
        @if ($banner['image'])
        <div class="form-group text-center">
            <label class="text-gray-600">Current Image</label>
            <div>
                <img src="{{ asset('images/banners/' . $banner['image']) }}" alt="{{ $banner['title'] }}"
                    class="img-fluid rounded shadow" style="max-width: 300px; height: auto;">
            </div>
        </div>
        @endif

        {{-- Submit Button --}}
        <div class="d-flex mt-4">
            <a href="{{ route('hero.index') }}" class="btn btn-secondary w-100 mr-2">Cancel</a>
            <button type="submit" class="btn btn-primary w-100 ml-2">Update</button>
        </div>
    </form>
</div>
@endsection