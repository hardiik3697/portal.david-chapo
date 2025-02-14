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
                <div class="text-end m-4">
                    <a href="{{ route('stripes.create') }}">
                        <button class="btn rounded-pill btn-outline-primary me-sm-4 me-2 waves-effect waves-light">+ Add New</button>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-datatable table-responsive pt-0">
                    <table class="datatables-basic table table-bordered" id="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@php $pageJs = ['resources/js/project/stripes/index.js']; @endphp
@endsection
