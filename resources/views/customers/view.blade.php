@extends('layout.app')

@section('meta') @endsection

@section('title') Customer @endsection

@section('styles')
<style>
    .card-min-height{
        min-height: 300px;
    }
</style>
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
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="name" id="name" class="form-control" value="{{ $data->name ?? '' }}" disabled>
                                <label for="name">Name</label>
                                <div class="error-name invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="email" name="email" id="email" class="form-control" value="{{ $data->email ?? '' }}" disabled>
                                <label for="email">Email Address</label>
                                <div class="error-email invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="phone" id="phone" class="form-control" value="{{ $data->phone ?? '' }}" disabled>
                                <label for="phone">Phone</label>
                                <div class="error-phone invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <select name="status" id="status" class="form-select" aria-label="Status" disabled>
                                <option selected="">Select Status</option>
                                <option value="active" @if($data->status == 'active') selected @endif>Active</option>
                                <option value="inactive" @if($data->status == 'inactive') selected @endif>Inactive</option>
                                <option value="deleted" @if($data->status == 'deleted') selected @endif>Deleted</option>
                            </select>
                        </div>
                        <hr class="my-1">
                        <div class="card-body">
                            @if(!empty($data) && !empty($data->platform))
                                @foreach($data->platform as $platform)
                                    <div class="row">
                                        <div class="col-sm-6 d-flex align-items-center mb-4">
                                            <i class="ri-macbook-line ri-24px"></i>
                                            <span class="fw-medium mx-2">:</span> <span>{{ $platform->platform_name ?? 'Unknown' }}</span>
                                        </div>
                                        <div class="col-sm-6 d-flex align-items-center mb-4">
                                            <i class="ri-user-3-line ri-24px"></i>
                                            <span class="fw-medium mx-2">:</span> <span>{{ $platform->username ?? 'JohnDoe' }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
