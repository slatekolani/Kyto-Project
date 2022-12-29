@extends('layouts.main', ['title' => trans('Trip Bookings'), 'header' => trans('Trip Bookings')])

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
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Total Custom Bookings') }} ~ {{$tour_operator->total_solo_bookings_label}} </h5>
                </a>
            </ul>
        </div>
    </div>

        <div class="col-md-4">
        <div class="list-group">
            <ul class="list-unstyled">
                <a href="{{route('touristBookings.verifiedTripsIndex',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Verified Trips') }} ~ {{$tour_operator->verified_trips_label}} </h5>
                    <p>To see, search <span class="badge badge-success">confirmed</span></p>
                </a>
            </ul>
        </div>
    </div>

        <div class="col-md-4">
        <div class="list-group">
            <ul class="list-unstyled">
                <a href="{{route('touristBookings.unverifiedTripsIndex',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Unverified Trips') }} ~ {{$tour_operator->Unverified_trips_label}}</h5>
                    <p>To see, search <span class="badge badge-warning">Unconfirmed</span></p>
                </a>
            </ul>
        </div>
    </div>

        <div class="col-md-4">
        <div class="list-group">
            <ul class="list-unstyled">
                <a href="{{route('payments.unverifiedTripPaymentsIndex',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Unchecked Transactions') }} ~ {{$tour_operator->unchecked_transactions_label}}</h5>
                    <p>To see, search <span class="badge badge-info">unchecked</span></p>
                </a>
            </ul>
        </div>
    </div>

        <div class="col-md-4">
        <div class="list-group">
            <ul class="list-unstyled">
                <a href="{{route('payments.verifiedTripPaymentsIndex',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Checked Transactions') }} ~ {{$tour_operator->checked_transactions_label}}</h5>
                    <p>To see, search <span class="badge badge-success">complete</span></p>
                </a>
            </ul>
        </div>
    </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="{{route('touristBookings.recent_trips_to_be_conducted_index',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Trips to be conducted on')}}</h5>
                        <p><span class="badge badge-light">{{date('F , Y')}}</span></p>
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
        <div class="list-group">
            <ul class="list-unstyled">
                <a href="{{route('touristBookings.overview',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Bookings Overview') }}</h5>
                </a>
            </ul>
        </div>
    </div>

        <div class="col-md-4">
        <div class="list-group">
            <ul class="list-unstyled">
                <a href="{{route('touristBookings.recent_bookings_index',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                    <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Recent Bookings') }} </h5>
                </a>
            </ul>
        </div>
    </div>
        @if($tourist_booking==null)
            <div class="col-md-4">
                <div class="list-group">
                    <ul class="list-unstyled">
                        <button onclick="alert('Please wait for a booking to be made')" class="list-group-item list-group-item-action">
                            <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Recent Transactions') }}</h5>
                        </button>
                    </ul>
                </div>
            </div>
        @else
        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="{{route('payments.recent_payments_index',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Recent Transactions') }}</h5>
                    </a>
                </ul>
            </div>
        </div>
        @endif


    </div>
    <div class="row" style="overflow-x: scroll">
        <div class="col-md-12">
            <section class="card card-primary mb-4" style="width:300%">

                @include('touristBookings.get_bookings')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
