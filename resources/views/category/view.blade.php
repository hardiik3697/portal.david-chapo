@extends('layout.app')

@section('meta') @endsection

@section('title') Category @endsection

@section('styles')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-6">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">View</h5>
            <small class="text-body float-end">Role {{ auth()->guard()->check() }}</small>
        </div>
        <div class="card-body">
            <div class="row g-6">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input type="text" name="name" id="name" class="form-control" value="{{ $data->name ?? '' }}" disabled>
                        <label for="name">Name</label>
                        <div class="error-name invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <textarea name="description" id="description" placeholder="description" class="form-control" disabled>{{ $data->description ?? '' }}</textarea>
                </div>

                <div class="col-md-6">
                    <a href="{{ route('category.index') }}"><button type="button" class="btn rounded-pill btn-outline-secondary waves-effect">Cancel</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@php $pageJs = ['resources/js/project/users/store.js']; @endphp
@endsection
