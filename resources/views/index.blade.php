@extends('layout.app')

@section('meta') @endsection

@section('title') Dashboard @endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-statistics.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-analytics.css') }}" />
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6">
        <div class="col-md-12 col-md-12">
            <div class="card">
                <div class="d-flex align-items-start row">
                    <div class="col-md-6 text-center text-md-start order-2 order-md-1">
                        <div class="d-flex align-items-end row">
                            <div class="col-md-8 order-1 order-md-2">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Welcome <span class="fw-bold">{{ auth()->user()->name ?? 'John' }}!</span> 🎉</h4>
                                    <p class="mb-0">You have done good work.</p>
                                    <p>Check your data and analytics.</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center text-md-start order-2 order-md-1">
                                <div class="card-body pb-0 px-0 pt-2">
                                    <img src="{{ asset('assets/img/illustrations/trophy.png') }}" height="186" class="scaleX-n1-rtl" alt="View Profile" data-app-light-img="illustrations/trophy.png" data-app-dark-img="illustrations/trophy.png">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 order-1 order-md-2">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Generate Link to send user</h4>
                            <div class="input-group input-group-floating">
                                <span class="input-group-text"><i class="ri-file-copy-line"></i></span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="generate_link" placeholder="Generate Link" aria-label="generate_link" aria-describedby="generate_link">
                                    <label for="basic-addon21">Generate Link</label>
                                </div>
                                <span class="form-floating-focused"></span>
                            </div>
                            <a href="javascript:;" id="generateButton" class="btn btn-primary btn-group-justified waves-effect waves-light">Generate Link</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded-3">
                                <i class="ri-shopping-cart-2-line ri-24px"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <p class="mb-0 text-success me-1">+22%</p>
                            <i class="ri-arrow-up-s-line text-success"></i>
                        </div>
                    </div>
                    <div class="card-info mt-5">
                        <h5 class="mb-1">155k</h5>
                        <p>Total Purchase</p>
                        <div class="badge bg-label-secondary rounded-pill">Last Days</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded-3">
                                <i class="ri-shopping-cart-2-line ri-24px"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <p class="mb-0 text-success me-1">+22%</p>
                            <i class="ri-arrow-up-s-line text-success"></i>
                        </div>
                    </div>
                    <div class="card-info mt-5">
                        <h5 class="mb-1">155k</h5>
                        <p>Total Paid</p>
                        <div class="badge bg-label-secondary rounded-pill">Last Day</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded-3">
                                <i class="ri-shopping-cart-2-line ri-24px"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <p class="mb-0 text-success me-1">+22%</p>
                            <i class="ri-arrow-up-s-line text-success"></i>
                        </div>
                    </div>
                    <div class="card-info mt-5">
                        <h5 class="mb-1">155k</h5>
                        <p>Total Purchase</p>
                        <div class="badge bg-label-secondary rounded-pill">Last Days</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded-3">
                                <i class="ri-shopping-cart-2-line ri-24px"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <p class="mb-0 text-success me-1">+22%</p>
                            <i class="ri-arrow-up-s-line text-success"></i>
                        </div>
                    </div>
                    <div class="card-info mt-5">
                        <h5 class="mb-1">155k</h5>
                        <p>Total Paid</p>
                        <div class="badge bg-label-secondary rounded-pill">Last Day</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
@php $pageJs = ['resources/js/project/dashboard/generate.js']; @endphp
@endsection
