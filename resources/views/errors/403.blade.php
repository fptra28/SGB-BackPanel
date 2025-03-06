@extends('layouts.admin')

@section('main-content')
<div class="container d-flex flex-column justify-content-center align-items-center">
    <div class="shadow border-secondary p-5 rounded shadow-lg text-center">
        <div class="mx-auto">
            <svg width="150px" height="150px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4 12C4 7.58172 7.58172 4 12 4C13.6284 4 15.1432 4.48652 16.4068 5.32214L6.07523 17.3757C4.78577 15.9554 4 14.0694 4 12ZM7.59321 18.6779C8.85689 19.5135 10.3716 20 12 20C16.4183 20 20 16.4183 20 12C20 9.93057 19.2142 8.04467 17.9248 6.62436L7.59321 18.6779ZM12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2Z"
                        fill="#ff0000"></path>
                </g>
            </svg>
        </div>
        <h1 class="mt-3"><strong>Access Denied</strong></h1>
        <h4>You do not have permission to view this page.</h4>
        <div class="mt-5">
            <small><strong>Error Code: </strong>403</small>
        </div>
        <div class="mt-5">
            <a href="{{ route('home') }}"><button class="btn btn-primary">Return to Dashboard</button></a>
        </div>
    </div>
</div>
@endsection