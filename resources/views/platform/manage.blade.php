@extends('layout.app')

@section('meta') @endsection

@section('title') Platform @endsection

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
            <form id="form" enctype="multipart/form-data">
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
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $data->name ?? '') }}">
                            <label for="name">Name</label>
                            <div class="error-name invalid-feedback">{{ $errors->first('name') }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="backend_url" id="backend_url" class="form-control" value="{{ old('backend_url', $data->backend_url ?? '') }}">
                            <label for="backend_url">Backend URL</label>
                            <div class="error-backend_url invalid-feedback">{{ $errors->first('backend_url') }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="frontend_url" id="frontend_url" class="form-control" value="{{ old('frontend_url', $data->frontend_url ?? '') }}">
                            <label for="frontend_url">Frontend URL</label>
                            <div class="error-frontend_url invalid-feedback">{{ $errors->first('frontend_url') }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <select name="status" id="status" class="form-select" placeholder="Status" aria-label="Status">
                            <option selected="" value="">Select Status</option>
                            <option value="active" @if(old('status', $data->status ?? '') == 'active') selected @endif>Active</option>
                            <option value="inactive" @if(old('status', $data->status ?? '') == 'inactive') selected @endif>Inactive</option>
                            <option value="deleted" @if(old('status', $data->status ?? '') == 'deleted') selected @endif>Deleted</option>
                        </select>
                        <div class="error-status invalid-feedback">{{ $errors->first('status') }}</div>
                    </div>
                    <div class="col-md-12">
                        <textarea name="description" id="description" placeholder="description" class="form-control">{{ old('description', $data->description ?? '') }}</textarea>
                        <div class="error-description invalid-feedback">{{ $errors->first('description') }}</div>
                    </div>

                    <div class="form-floating form-floating-outline mb-6">
                        <input type="file" name="logo" class="form-control" id="basic-default-upload-file">
                        <label for="basic-default-upload-file">Logo</label>
                        <div class="error-logo invalid-feedback">{{ $errors->first('logo') }}</div>
                    </div>

                    <div class="form-floating form-floating-outline mb-6">
                        <input type="file" name="image" class="form-control" id="basic-default-upload-file-2">
                        <label for="basic-default-upload-file-2">Image</label>
                        <div class="error-image invalid-feedback">{{ $errors->first('image') }}</div>
                    </div>

                    <div class="col-md-6">
                        <button type="submit" class="btn rounded-pill btn-outline-primary waves-effect">Submit</button>
                        <a href="{{ route('platform.index') }}"><button type="button" class="btn rounded-pill btn-outline-secondary waves-effect">Cancel</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@php $pageJs = ['resources/js/project/platform/store.js']; @endphp
@endsection
