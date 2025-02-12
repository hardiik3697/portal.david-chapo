@extends('layout.app')

@section('meta') @endsection

@section('title') Settings @endsection

@section('styles')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-align-top">
                <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-2 gap-lg-0">
                    @if(!empty($tabs))
                        @foreach($tabs as $tab)
                        <?php
                            if($tab['type'] == 'general'){
                                $icon = 'ri-microsoft-fill';
                            }elseif($tab['type'] == 'social'){
                                $icon = 'ri-global-line';
                            }else{
                                $icon = 'ri-macbook-line';
                            }
                        ?>
                        <li class="nav-item me-3">
                            <a class="nav-link @if($param == $tab['type']) active @endif" href="{{ route('setting.index') }}/{{ $tab['type'] }}">
                                <i class="<?= $icon ?> me-2"></i>{{ $tab['type'] }}
                            </a>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="card mb-6">
                <form action="{{ route('setting.update') }}" method="post" class="card-body">
                    @method('post')
                    @csrf
                    <input type="hidden" name="param" value="{{ $param }}">
                    <div class="row g-6">
                        @if(isset($data) && $data->isNotEmpty())
                            @foreach($data as $row)
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" name="{{ $row->id }}" id="{{ $row['id'] }}" class="form-control" placeholder="" value="{{ $row['value'] }}">
                                        <label for="{{ $row['id'] }}">{{ strtoupper(str_replace('_', ' ', $row->key)) }}</label>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="pt-6">
                        <button type="submit" class="btn btn-primary me-4 waves-effect waves-light">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
