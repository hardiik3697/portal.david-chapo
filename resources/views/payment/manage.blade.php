@extends('layout.app')

@section('meta') @endsection

@section('title') Payment @endsection

@section('styles')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card mb-6">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ !empty($data->id) ? "Edit" : "Add" }} Payment</h5>
                    <small class="text-body float-end">Role {{ auth()->guard()->check() }}</small>
                </div>
            </div>
            <div class="card mb-6">
                <div class="card-body">
                    <form id="form">
                        @csrf

                        @if(!empty($data->id))
                            @method('PATCH')
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <input type="hidden" name="customer_id" value="{{ $data->customer_id }}">
                            <input type="hidden" name="customer_platform_id" value="{{ $data->customer_platform_id }}">
                        @else
                            @method('POST')
                        @endif

                        <div class="row g-6">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline ">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $data->customer_name ?? '' }}">
                                    <label for="name">Name</label>
                                    <div class="error-name invalid-feedback mx-3"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline ">
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $data->customer_phone ?? '' }}">
                                    <label for="phone">Phone</label>
                                    <div class="error-phone invalid-feedback mx-3"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline ">
                                    <input type="text" name="email" id="email" class="form-control" value="{{ $data->customer_email ?? '' }}">
                                    <label for="email">Email</label>
                                    <div class="error-email invalid-feedback mx-3"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline ">
                                    <input type="text" name="username" id="username" class="form-control" value="{{ $data->username ?? '' }}">
                                    <label for="username">Username</label>
                                    <div class="error-username invalid-feedback mx-3"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="platform_id" id="platform_id" class="form-select" data-allow-clear="true">
                                        <option value="">Plateform</option>
                                        @if(!empty($platforms) && $platforms->isNotEmpty())
                                            @foreach ($platforms as $row)
                                                <?php
                                                    $selected = '';
                                                    if(!empty($data))
                                                        if($data->platform_id == $row->id)
                                                            $selected = 'selected';
                                                ?>
                                                <option value="{{ $row->id }}" {{ $selected }}>{{ ucwords($row->name) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="platform_id">Plateform</label>
                                    <div class="error-platform_id invalid-feedback mx-3"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" name="amount" id="amount" class="form-control" value="{{ $data->amount ?? 0 }}">
                                    <label for="amount">Amount</label>
                                    <div class="error-amount invalid-feedback mx-3"></div>
                                </div>
                            </div>
                            @if(!empty($data->id))
                                <div class="col-sm-6">
                                    <div class="form-floating form-floating-outline">
                                        <select name="payment_status" id="payment_status" class="form-select" data-allow-clear="true">
                                            <option value="">Payment Status</option>
                                            <option value="pending" @if($data->payment_status == 'pending') selected @endif>Pending</option>
                                            <option value="succeeded" @if($data->payment_status == 'succeeded') selected @endif>Succeeded</option>
                                        </select>
                                        <label for="payment_status">Payment Status</label>
                                        <div class="error-payment_status invalid-feedback mx-3"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating form-floating-outline">
                                        <select name="recharge_status" id="recharge_status" class="form-select" data-allow-clear="true">
                                            <option value="">Payment Status</option>
                                            <option value="pending" @if($data->recharge_status == 'pending') selected @endif>Pending</option>
                                            <option value="done" @if($data->recharge_status == 'done') selected @endif>Done</option>
                                        </select>
                                        <label for="recharge_status">Recharge Status</label>
                                        <div class="error-recharge_status invalid-feedback mx-3"></div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <button type="submit" class="btn rounded-pill btn-primary waves-effect waves-light mx-2">Submit</button>
                                <a href="{{ route('payment.index') }}"><button type="button" class="btn rounded-pill btn-outline-secondary waves-effect">Cancel</button></a>
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
@php $pageJs = ['resources/js/project/payment/store.js']; @endphp
@endsection
