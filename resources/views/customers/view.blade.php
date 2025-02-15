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
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="card mb-6 card-min-height">
                        <div class="card-header align-items-center">
                            <h5 class="card-action-title mb-0">
                                <i class="ri-user-4-line ri-24px text-body me-4"></i>About
                            </h5>
                        </div>
                        <hr class="my-1">
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-center mb-4">
                                    <i class="ri-user-3-line ri-24px"></i>
                                    <span class="fw-medium mx-2">Full Name:</span> <span>{{ $data->name ?? 'John Doe' }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-4">
                                    <i class="ri-phone-line ri-24px"></i>
                                    <span class="fw-medium mx-2">Contact:</span> <span>{{ $data->phone ?? '9998887771' }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-4">
                                    <i class="ri-mail-open-line ri-24px"></i>
                                    <span class="fw-medium mx-2">Email:</span> <span>{{ $data->email ?? 'john.doe@example.com' }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-4">
                                    <?php 
                                        if(!empty($data) && $data->status == 'active'){
                                            $status = 'Active';
                                            $icon = 'ri-check-line';
                                        }elseif(!empty($data) && $data->status == 'inactive'){
                                            $status = 'Inactive';
                                            $icon = 'ri-close-line';
                                        }elseif(!empty($data) && $data->status == 'deleted'){
                                            $status = 'Deleted';
                                            $icon = 'ri-delete-bin-line';
                                        }else{
                                            $status = 'Unknown';
                                            $icon = 'ri-filter-off-line';
                                        }
                                    ?>
                                    <i class="<?php echo $icon; ?> ri-24px"></i>
                                    <span class="fw-medium mx-2">Status:</span> 
                                    <span><?php echo $status; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="card mb-6 card-min-height">
                        <div class="card-header align-items-center">
                            <h5 class="card-action-title mb-0">
                                <i class="ri-macbook-line ri-24px text-body me-4"></i>Platform
                            </h5>
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