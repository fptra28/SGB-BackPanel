@extends('layouts.auth')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-dark">
                            <img src="{{ asset('img/LOGO-SGB-Mini-Account.png') }}" alt="Logo" class="img-fluid"
                                style="max-width: 80%; height: auto;">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('Login') }}</h1>
                                </div>

                                @if ($errors->any())
                                <div class="alert alert-danger border-left-danger" role="alert">
                                    <ul class="pl-4 my-2">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}" class="user">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email"
                                            placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required
                                            autofocus>
                                    </div>

                                    <div class="mb-3">
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-user password-field"
                                                id="password" name="password" placeholder="{{ __('Password') }}"
                                                required>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary toggle-password" type="button"
                                                    id="togglePassword">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="remember">{{ __('Remember Me')
                                                }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-dark btn-user btn-block">
                                            {{ __('LOGIN') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection