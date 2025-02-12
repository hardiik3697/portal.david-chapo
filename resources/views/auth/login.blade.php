@extends('auth.layout.app')

@section('meta') @endsection

@section('title') Login @endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
@endsection

@section('content')
<div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
    <div class="w-px-400 mx-auto pt-5 pt-lg-0">
        <h4 class="mb-3">Welcome to {{ __settings('SITE_TITLE') }}! 👋</h4>

        <form id="loginForm" method="POST" action="{{ route('signin') }}">
            @csrf

            <div class="form-floating form-floating-outline mb-5">
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" autofocus />
                <label for="username">Username</label>
                <div class="error-username invalid-feedback mx-3"></div>
            </div>
            <div class="mb-5">
                <div class="form-password-toggle">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="password" name="password" id="password" class="form-control" aria-describedby="password" />
                            <label for="password">Password</label>
                        </div>
                        <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                        <div class="error-password invalid-feedback mx-3"></div>
                    </div>
                </div>
            </div>
            <div class="mb-5 d-flex justify-content-between mt-5">
                <div class="form-check mt-2">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input" value="1" />
                    <label class="form-check-label" for="remember"> Remember Me </label>
                </div>
            </div>
            <button class="btn btn-primary d-grid w-100">Sign in</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
@php $pageJs = ['resources/js/project/auth/login.js']; @endphp
@endsection
