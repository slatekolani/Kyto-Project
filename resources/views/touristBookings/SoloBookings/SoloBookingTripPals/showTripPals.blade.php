@extends('layouts.main', ['title' => 'Trip Pals', 'header' => 'Trip Pals'])

@push('after-styles')
    {{ Html::style(url('vendor/select2/css/select2.min.css')) }}

@endpush
@section('content')
    <div class="container">
        <div class="content">

            <div class="row">
                <div class="col-md-4">
                    <div class="list-group">
                        <ul class="list-unstyled">
                            <a href="#" class="list-group-item list-group-item-action">
                                <h5 class="list-group-item-heading" style="font-family: sans-serif, Verdanau"><i class="fas fa-clipboard"></i> {{ __('Amount to be Paid') }}</h5>
                            </a>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="list-group">
                        <ul class="list-unstyled">
                            <a href="#" class="list-group-item list-group-item-action">
                                <h5 class="list-group-item-heading" style="font-family: sans-serif, Verdana"><i class="fas fa-clipboard"></i> {{ __('Amount Paid') }}</h5>
                            </a>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="list-group">
                        <ul class="list-unstyled">
                            <a href="#" class="list-group-item list-group-item-action">
                                <h5 class="list-group-item-heading" style="font-family: sans-serif, Verdana"><i class="fas fa-clipboard"></i> {{ __('Amount Remaining') }}</h5>
                            </a>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="list-group">
                        <ul class="list-unstyled">
                            <a href="#" class="list-group-item list-group-item-action">
                                <h5 class="list-group-item-heading" style="font-family: sans-serif, Verdana"><i class="fas fa-clipboard"></i>Start Date: {{date('jS M Y',strtotime($solo_bookings->start_date))}}</h5>
                            </a>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="list-group">
                        <ul class="list-unstyled">
                            <a href="#" class="list-group-item list-group-item-action">
                                <h5 class="list-group-item-heading" style="font-family: sans-serif, Verdana"><i class="fas fa-clipboard"></i>End Date: {{date('jS M Y',strtotime($solo_bookings->end_date))}}</h5>
                            </a>
                        </ul>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="list-group">
                        <ul class="list-unstyled">
                            <a href="#" class="list-group-item list-group-item-action">
                                <h5 class="list-group-item-heading" style="font-family: sans-serif, Verdana"><i class="fas fa-clipboard"></i>Countdown Days: {{$solo_bookings->NumberOfDaysRemainedForSoloTripLabel}} </h5>
                                @if($solo_bookings->NumberOfDaysRemainedForSoloTripLabel < 1)
                                    <p><span class="badge badge-success">Proceed with Payments</span></p>
                                @else
                                    <p><span class="badge badge-danger">Out of Range. Contact the tour operator for an extension</span></p>
                                @endif
                            </a>
                        </ul>
                    </div>
                </div>
            </div>




            <div style="position: relative;">
                <a href="{{route('soloBookingTripPals.create',$solo_bookings->uuid)}}"><i class="fa fa-pen-square">Add Trip Pal</i></a>
                <span style="float:right;font-family: sans-serif, Verdana">TRIP CODE : <span class="badge badge-light" style="font-size: 15px">{{$solo_bookings->trip_code}} </span></span>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body" style="border: 2px solid gainsboro">
                            <a href="{{route('soloTouristAccountInformation.show',$solo_bookings->uuid)}}" class="btn btn-primary btn-sm">&larr;Payment Accounts</a>
                            <form class="search-bar" type="get" action="#" style="padding-bottom: 20px">
                                <div class="input-group">
                                    <div class="form-outline">
                                        <input type="search" id="form1" name="search" class="form-control" placeholder="search..."/>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>

                            <table class="table table-hover table-responsive-md">
                                <thead>
                                <tr>
                                    <th>Tourist name</th>
                                    <th>Phone number</th>
                                    <th>Email address</th>
                                    <th>Amount Contributed</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>

                                @if(!empty($solo_booking_trip_pals) && $solo_booking_trip_pals->count())
                                    @foreach($solo_booking_trip_pals as $solo_booking_trip_pal)
                                        <tbody>
                                        <tr>
                                            <td>{{$solo_booking_trip_pal->tourist_name}}</td>
                                            <td><a href="tel:{{$solo_booking_trip_pal->phone_number}}">{{$solo_booking_trip_pal->phone_number}}</a></td>
                                            <td><a href="mailto:{{$solo_booking_trip_pal->email_address}}">{{$solo_booking_trip_pal->email_address}}</a></td>
                                            @if($solo_booking_trip_pal->soloBookings->tourist_nation==1)
                                            <td>{{$solo_booking_trip_pal->trip_amount}} shillings</td>
                                            @else
                                                <td>$ {{$solo_booking_trip_pal->trip_amount}}</td>
                                            @endif
                                            <td>
                                                <a href="#" class="btn btn-primary btn-sm">Update</a>
                                                <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                        </tbody>

                                    @endforeach
                                @else
                                    <span style="float:right">No pal joined for this trip</span>
                                @endif

                            </table>
                        </div>
                    </div>



                </div>




            </div>
        </div>
    </div>

@endsection
