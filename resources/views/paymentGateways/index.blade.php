@extends('layouts.main', ['title' => trans('Payment gateways'), 'header' => trans('Payment gateways')])

@include('includes.datatable_assets')
@push('after-styles')
    {{ Html::style(url('vendor/sweetalert/sweetalert.css')) }}

    <style>

    </style>
@endpush
@section('content')

    <div class="row">
        <div class="col-md-12">
            <section class="card card-primary mb-4">
                <a class='' href="{{ route('paymentGateway.create') }}"><i
                        class="fas fa-pencil-alt"></i>&nbsp;{{ trans('Add gateway') }}</a>&nbsp;&nbsp;
                @include('paymentGateways.get_payment_gateways')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
