@extends('layout.app')

@section('meta') @endsection

@section('title') Payment @endsection

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
                <div class="col-xl-4 col-lg-4 col-md-4">
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
                                    <span class="fw-medium mx-2">Full Name:</span> <span>{{ $data->customer_name ?? 'John Doe' }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-4">
                                    <i class="ri-phone-line ri-24px"></i>
                                    <span class="fw-medium mx-2">Contact:</span> <span>{{ $data->customer_phone ?? '9998887771' }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-4">
                                    <i class="ri-mail-open-line ri-24px"></i>
                                    <span class="fw-medium mx-2">Email:</span> <span>{{ $data->customer_email ?? 'john.doe@example.com' }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-4">
                                    <?php 
                                        if(!empty($data) && $data->customer_status == 'active'){
                                            $status = 'Active';
                                            $icon = 'ri-check-line';
                                        }elseif(!empty($data) && $data->customer_status == 'inactive'){
                                            $status = 'Inactive';
                                            $icon = 'ri-close-line';
                                        }elseif(!empty($data) && $data->customer_status == 'deleted'){
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
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="card mb-6 card-min-height">
                        <div class="card-header align-items-center">
                            <h5 class="card-action-title mb-0">
                                <i class="ri-shopping-cart-2-line ri-24px text-body me-4"></i>Finance
                            </h5>
                        </div>
                        <hr class="my-1">
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-center mb-4">
                                    <?php
                                        if(!empty($data) && $data->payment_type == 'stripe'){
                                            $icon = 'ri-wallet-line';
                                            $type = 'Online';
                                        }elseif(!empty($data) && $data->payment_type == ''){
                                            $icon = 'ri-cash-fill';
                                            $type = 'Cash';
                                        }
                                    ?>
                                    <i class="<?= $icon ?> ri-24px"></i>
                                    <span class="fw-medium mx-2">Payment Type:</span> 
                                    <span><?= $type ?></span>
                                </li>
                                <li class="d-flex align-items-center mb-4">
                                    <i class="ri-login-circle-line ri-24px"></i>
                                    <span class="fw-medium mx-2">Payment Status:</span> 
                                    <span>
                                        <?php 
                                            if(!empty($data) && $data->payment_status){
                                                echo ucfirst($data->payment_status);
                                            }else{
                                                echo 'Unknown';
                                            }
                                        ?>
                                    </span>
                                </li>
                                <li class="d-flex align-items-center mb-4">
                                    <i class="ri-logout-circle-line ri-24px"></i>
                                    <span class="fw-medium mx-2">Recharge Status:</span> 
                                    <span>
                                        <?php 
                                            if(!empty($data) && $data->recharge_status){
                                                echo ucfirst($data->recharge_status);
                                            }else{
                                                echo 'Unknown';
                                            }
                                        ?>
                                    </span>
                                </li>
                                <li class="d-flex align-items-center mb-4">
                                    <i class="ri-stack-line ri-24px"></i>
                                    <span class="fw-medium mx-2">Payment ID:</span> 
                                    <span><?php 
                                            if(!empty($data) && $data->payment_id){
                                                echo chunk_split($data->payment_id, 20, "\n");
                                            }else{
                                                echo 'Unknown';
                                            }
                                        ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <div class="card mb-6 card-min-height">
                        <div class="card-header align-items-center">
                            <h5 class="card-action-title mb-0">
                                <i class="ri-macbook-line ri-24px text-body me-4"></i>Platform
                            </h5>
                        </div>
                        <hr class="my-1">
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-center mb-4">
                                    <i class="ri-macbook-line ri-24px"></i>
                                    <span class="fw-medium mx-2">Plateform:</span> <span>{{ $data->platform_name ?? 'Unknown' }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-4">
                                    <i class="ri-user-3-line ri-24px"></i>
                                    <span class="fw-medium mx-2">Username:</span> <span>{{ $data->username ?? 'JohnDoe' }}</span>
                                </li>
                            </ul>
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