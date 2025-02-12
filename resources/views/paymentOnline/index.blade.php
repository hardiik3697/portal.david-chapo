@extends('layout.app')

@section('meta') @endsection

@section('title') Online Payment @endsection

@section('styles')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6">
        <div class="col-md-12 col-xxl-12">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-7 col-12 order-2 order-md-0">
                        <div class="card-header">
                            <h5 class="mb-0">Online Accounts</h5>
                        </div>
                        <div class="card-body" style="position: relative;">
                            <div>
                                <div class="d-flex justify-content-start align-items-center user-name">
                                    <div class="avatar-wrapper">
                                        <h4 class="px-2">
                                            <i class="ri-database-2-fill ri-20px"></i>
                                        </h4>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="name text-truncate h3">{{ $email ?? '' }}</span>
                                    </div>
                                </div>
                                <select id="mySelect" class="form-select">
                                    @if(!empty($stripes))
                                        @foreach($stripes as $k => $v)
                                            <option @if($email == $v->email) selected @endif data-route={{ route('paymentOnline.index', base64_encode($v->id)) }}>{{ $v->email }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-12">
                        <div class="card-header">
                            <div class="d-flex justify-content-center">
                                <h5 class="mb-1">Reports</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 border-end">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-success rounded-3">
                                                <div class="ri-money-dollar-circle-line ri-24px"></div>
                                            </div>
                                        </div>
                                        <p class="mt-3 mb-1">Available Amount</p>
                                        <h2 class="mb-0">{{ $available ?? '$0.00' }}</h2>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-label-primary rounded-3">
                                                <div class="ri-exchange-dollar-line ri-24px"></div>
                                            </div>
                                        </div>
                                        <p class="mt-3 mb-1">Pending Amount</p>
                                        <h2 class="mb-0">{{ $pending ?? '$0.00' }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-6">
                <div class="card-datatable table-responsive pt-0">
                    <table class="datatables-basic table table-bordered" id="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Amount</th>
                                <th>Platform</th>
                                <th>Payment</th>
                                <th>Recharge</th>
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
<script>
    const PAYMENT_ID = "{{ base64_encode($id) }}";
</script>
@php $pageJs = ['resources/js/project/paymentOnline/index.js']; @endphp
@endsection
