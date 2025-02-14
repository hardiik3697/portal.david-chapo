@extends('layout.app')

@section('meta') @endsection

@section('title') Stripe @endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ !empty($data) ? "Edit" : "Add" }} Stripe</h5>
                    <small class="text-body float-end">Role {{ auth()->guard()->check() }}</small>
                </div>
            </div>
            <div class="card mb-6">
                <div class="card-body">
                    <form id="form">
                        @csrf

                        @if(!empty($data))
                            @method('PATCH')
                            <input type="hidden" name="id" value="{{ $data->id }}">
                        @else
                            @method('POST')
                        @endif

                        <div class="row g-6">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="email" name="email" id="email" class="form-control" value="{{ $data->email ?? '' }}" placeholder="john@doe.in">
                                    <label for="email">Email Address</label>
                                    <div class="error-email invalid-feedback mx-3"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="publishable_key" id="publishable_key" class="form-control" value="{{ $data->publishable_key ?? '' }}" placeholder="John Doe">
                                    <label for="publishable_key">Publishable key</label>
                                    <div class="error-publishable_key invalid-feedback mx-3"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="secret_key" id="secret_key" class="form-control" value="{{ $data->secret_key ?? '' }}" placeholder="John Doe">
                                    <label for="secret_key">Secret key</label>
                                    <div class="error-secret_key invalid-feedback mx-3"></div>
                                </div>
                            </div>
                            @if(!empty($data))
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select id="status" name="status" class="form-select"data-placeholder="Select Status">
                                        <option data-tokens="{{ $data->status }}" value="active">Active</option>
                                        <option data-tokens="{{ $data->status }}" value="inactive" @if($data->status == 'inactive') selected @endif>Inactive</option>
                                        <option data-tokens="{{ $data->status }}" value="deleted" @if($data->status == 'deleted') selected @endif>Deleted</option>
                                    </select>
                                    <label for="status">Status</label>
                                </div>
                                <div class="error-status invalid-feedback mx-3"></div>
                            </div>
                            <div class="col-md-6"></div>
                            @endif
                            <div class="col-md-6">
                                <button type="submit" class="btn rounded-pill btn-primary waves-effect waves-light mx-2">Submit</button>
                                <a href="{{ route('stripes.index') }}"><button type="button" class="btn rounded-pill btn-outline-secondary waves-effect">Back</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/js/forms-selects.js') }}"></script>
@php $pageJs = ['resources/js/project/stripes/store.js']; @endphp
@endsection
