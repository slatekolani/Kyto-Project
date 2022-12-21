@extends('layouts.main', ['title' => trans('Accounts'), 'header' => trans('Accounts')])

@include('includes.datatable_assets')
@push('after-styles')
    {{ Html::style(url('vendor/sweetalert/sweetalert.css')) }}

    <style>

    </style>
@endpush
@section('content')
    <div class="row">

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Number of Accounts') }} ~ <span class="badge badge-pill badge-success" style="padding:8px">{{$tour_operator->number_of_accounts_label}}</span></h5>
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Number of active accounts') }} ~ <span class="badge badge-pill badge-success" style="padding:8px">{{$tour_operator->number_of_accounts_active_label}}</span></h5>
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Number of inactive accounts') }} ~ <span class="badge badge-pill badge-success" style="padding:8px">{{$tour_operator->number_of_inactive_accounts_label}}</span></h5>
                    </a>
                </ul>
            </div>
        </div>
    </div>
    <div class="row" style="overflow-x: scroll">
        <div class="col-md-12">
            <section class="card card-primary mb-4" style="width:105%">
                <a class='' href="{{ route('tourOperatorAccounts.create',$tour_operator->uuid) }}"><i
                        class="fas fa-pencil-alt"></i>&nbsp;{{ trans('Add account') }}</a>&nbsp;&nbsp;
                @include('tourOperatorAccounts.get_tour_operator_account')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
