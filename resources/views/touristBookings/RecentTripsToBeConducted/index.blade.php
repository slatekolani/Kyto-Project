@extends('layouts.main', ['title' => trans('Recent Trips To Be Conducted'), 'header' => trans('Recent Trips To Be Conducted')])

@include('includes.datatable_assets')
@push('after-styles')
    {{ Html::style(url('vendor/sweetalert/sweetalert.css')) }}

    <style>

    </style>
@endpush
@section('content')
    <div class="row" style="overflow-x: scroll">
        <div class="col-md-12">
            <section class="card card-primary mb-4" style="width:300%">

                @include('touristBookings.RecentTripsToBeConducted.get_recent_trips_to_be_conducted')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
