@extends('layouts.main', ['title' => trans('Verified Solo Trip Payments'), 'header' => trans('Verified Solo Trip Payments')])

@include('includes.datatable_assets')
@push('after-styles')
    {{ Html::style(url('vendor/sweetalert/sweetalert.css')) }}

    <style>

    </style>
@endpush
@section('content')

    <div class="row">
    </div>
    <div class="row" style="overflow-x: scroll">
        <div class="col-md-12" >
            <section class="card card-primary mb-4" style="width:180%">

                @include('payments.soloPayments.VerifiedSoloTripPayments.get_verified_solo_trip_payments')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
