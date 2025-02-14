@extends('layout.app')

@section('meta') @endsection

@section('title') Stripe @endsection

@section('styles')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View</h5>
                    <small class="text-body float-end">Role {{ auth()->guard()->check() }}</small>
                </div>
            </div>
            <div class="card mb-6">
                <div class="card-body">
                    <div class="row g-6">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="email" name="email" id="email" class="form-control" value="{{ $data->email ?? '' }}" disabled>
                                <label for="email">Email Address</label>
                                <div class="error-email invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="publishable_key" id="publishable_key" class="form-control" value="{{ $data->publishable_key ?? '' }}" disabled>
                                <label for="publishable_key">Publishable key</label>
                                <div class="error-publishable_key invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="secret_key" id="secret_key" class="form-control" value="{{ $data->secret_key ?? '' }}" disabled>
                                <label for="secret_key">Secret key</label>
                                <div class="error-secret_key invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <select name="status" id="status" class="form-select" aria-label="Status" disabled>
                                <option selected="">Select Status</option>
                                <option value="active" @if($data->status == 'active') selected @endif>Active</option>
                                <option value="inactive" @if($data->status == 'inactive') selected @endif>Inactive</option>
                                <option value="deleted" @if($data->status == 'deleted') selected @endif>Deleted</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('stripes.index') }}"><button type="button" class="btn rounded-pill btn-outline-secondary waves-effect">Back</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@php $pageJs = ['resources/js/project/stripes/store.js']; @endphp
@endsection
