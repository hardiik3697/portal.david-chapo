@extends('layout.app')

@section('meta') @endsection

@section('title') Customer @endsection

@section('styles')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ !empty($data) ? "Edit" : "Add" }} Customer</h5>
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
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $data->name ?? '' }}" placeholder="John Doe">
                                    <label for="name">Name</label>
                                    <div class="error-name invalid-feedback mx-3"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="email" name="email" id="email" class="form-control" value="{{ $data->email ?? '' }}" placeholder="john@doe.in">
                                    <label for="email">Email Address</label>
                                    <div class="error-email invalid-feedback mx-3"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $data->phone ?? '' }}" placeholder="9998886665">
                                    <label for="phone">Phone Number</label>
                                    <div class="error-phone invalid-feedback mx-3"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <select name="status" id="status" class="form-select" aria-label="Status">
                                    <option selected="">Select Status</option>
                                    <option value="active" @if(!empty($data) && $data->status == 'active') selected @endif>Active</option>
                                    <option value="inactive" @if(!empty($data) && $data->status == 'inactive') selected @endif>Inactive</option>
                                    <option value="deleted" @if(!empty($data) && $data->status == 'deleted') selected @endif>Deleted</option>
                                </select>
                                <div class="error-status invalid-feedback mx-3"></div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn rounded-pill btn-primary waves-effect waves-light mx-2">Submit</button>
                                <a href="{{ route('customers.index') }}"><button type="button" class="btn rounded-pill btn-outline-secondary waves-effect">Back</button></a>
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
@php $pageJs = ['resources/js/project/customers/store.js']; @endphp
@endsection
