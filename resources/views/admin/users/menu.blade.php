@extends('layouts.main', ['title' => __('Manage System Categories'), 'header' => __('Manage System Categories')])

@include('includes.datatable_assets')

@section('content')

    {{--1--}}
    <div class="row">

    <div class="col-md-4">
        <div class="list-group">
            <ul class="list-unstyled">
                <a href="{{ route('admin.user_manage.system_users') }}" class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('label.administrator.users.system_users') }}</h5>
                    <p class="list-group-item-text">@lang('label.administrator.users.manage_users')</p>
                </a>
            </ul>
        </div>
    </div>

        <div class="col-md-4">
        <div class="list-group">
            <ul class="list-unstyled">
                <a href="{{ route('paymentGateway.index') }}" class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Payment Gateways') }}</h5>
                    <p class="list-group-item-text">@lang('Payment Gateways')</p>
                </a>
            </ul>
        </div>
    </div>

        <div class="col-md-4">
        <div class="list-group">
            <ul class="list-unstyled">
                <a href="{{ route('MemberNationality.index') }}" class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Member Nations') }}</h5>
                    <p class="list-group-item-text">@lang('Member nations')</p>
                </a>
            </ul>
        </div>
    </div>


        <div class="col-md-4">
        <div class="list-group">
            <ul class="list-unstyled">
                <a href="{{ route('Language.index') }}" class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Language') }}</h5>
                    <p class="list-group-item-text">@lang('Languages')</p>
                </a>
            </ul>
        </div>
    </div>

        <div class="col-md-4">
        <div class="list-group">
            <ul class="list-unstyled">
                <a href="{{ route('touristAttraction.index') }}" class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Tourist Attractions') }}</h5>
                    <p class="list-group-item-text">@lang('Tourist Attractions')</p>
                </a>
            </ul>
        </div>
    </div>

        <div class="col-md-4">
        <div class="list-group">
            <ul class="list-unstyled">
                <a href="{{ route('specialCare.index') }}" class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Special Care') }}</h5>
                    <p class="list-group-item-text">@lang('Special Care')</p>
                </a>
            </ul>
        </div>
    </div>

        <div class="col-md-4">
        <div class="list-group">
            <ul class="list-unstyled">
                <a href="{{ route('tourType.index') }}" class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Tour Types ') }}</h5>
                    <p class="list-group-item-text">@lang('Tour Types ')</p>
                </a>
            </ul>
        </div>
    </div>

        <div class="col-md-4">
        <div class="list-group">
            <ul class="list-unstyled">
                <a href="{{ route('transportService.index') }}" class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Transport Service ') }}</h5>
                    <p class="list-group-item-text">@lang('Transport Service ')</p>
                </a>
            </ul>
        </div>
    </div>

    </div>
@endsection
