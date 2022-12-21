@extends('layouts.main', ['title' => 'Solo Bookings', 'header' => 'Solo Bookings'])

@push('after-styles')
    {{ Html::style(url('vendor/select2/css/select2.min.css')) }}

@endpush
@section('content')
    <div class="container">
        <div class="content-body">
            <form class="search-bar" type="get" action="{{route('soloBookings.search_Trip_booked_solo')}}">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="search" id="form1" name="search" class="form-control" placeholder="search Trip Record"/>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            <div class="row" style="padding-top: 20px">
                <div class="col-md-9">
                    @if(!empty($solo_bookings) && $solo_bookings->count())
                    @foreach($solo_bookings as $solo_booking)
                        <div class="card" style="border: 2px solid gainsboro">
                            <div class="card-body">
                                <div class="end_contents" style="border-bottom: 1px solid gainsboro">
                                    <img src="{{asset('public/logo_uploads/Logo/'.$solo_booking->logo)}}"
                                         style="width:70px;height:70px">
                                    <h4 style="padding-left: 10px">Trip with {{$solo_booking->company_name}}</h4>
                                    <a href="#" style="float:right">Print Record &darr;</a>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div style="position:relative">
                                                    <a href="#"><i class="fas fa-pencil-alt"></i> Trip Pals</a>
                                                    <a href="#" style="float: right"><button class="btn btn-primary btn-sm">Payment history &rarr;</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div style="padding-top:5px;border-bottom: 1px solid gainsboro">
                                    <table class="table table-hover table-responsive-md">
                                        <tr>
                                            <th>Tourist name/requester</th>
                                            <td>{{$solo_booking->tourist_name}}</td>
                                            <th>Tourist nation</th>
                                            <td>{{$solo_booking->nation_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Number of Travellers</th>
                                            <td>{{$solo_booking->number_of_tourists}}</td>
                                            <th>Trip to</th>
                                            <td>{{$solo_booking->attraction_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Start date</th>
                                            <td>{{date('jS M Y',strtotime($solo_booking->start_date))}}</td>
                                            <th>End date</th>
                                            <td>{{date('jS M Y',strtotime($solo_booking->end_date))}}</td>
                                        </tr>
                                        <tr>
                                            <th>Days</th>
                                            <td>{{Auth::user()->getNumberOfDaysForSoloTrip($solo_booking)}} days</td>
                                            <th>Trip Approval</th>
                                            <td><span class="badge badge-info">Unapproved</span></td>
                                        </tr>
                                        <tr>
                                            <th>Amount to be Paid</th>
                                            <td><span class="badge badge-light">Wait...</span></td>
                                            <th>Due Payment</th>
                                            <td>{{$solo_booking->payment_range}}</td>
                                        </tr>


                                    </table>

                                </div>
                                <div class="col-md-12" style="padding-top: 10px">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a href="#"><button class="btn btn-primary btn-sm">Rate</button></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="mailto:info@kytotz.com"><button class="btn btn-warning btn-sm">Report</button></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="{{route('soloBookings.edit',$solo_booking->uuid)}}"><button class="btn btn-group-toggle btn-sm">Adjust</button></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="#"><button class="btn btn-info btn-sm">Pay bill</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                        <span>Whoops! sorry we couldn't find what you are looking for.</span>
                    @endif

                </div>

                <div class="col-md-3">
                    <div class="card" style="border: 2px solid gainsboro">
                        <div class="card-body">
                            <div class="col-lg-14">
                                <div class="heading">
                                    <h4><b>Booking summary</b></h4>
                                    <hr>
                                    <h4 style="font-family: sans-serif, Verdana">Trips booked ~ <span class="badge badge-info">{{Auth::user()->getUserSoloTourBookings()->count()}}</span></h4>
                                    <h4 style="font-family: sans-serif, Verdana">Trips approved ~ <span class="badge badge-info">{{Auth::user()->getUserSoloTourBookings()->where('status','=',1)->count()}}</span></h4>
                                    <h4 style="font-family: sans-serif, Verdana">Trips unapproved ~ <span class="badge badge-info">{{Auth::user()->getUserSoloTourBookings()->where('status','=',0)->count()}}</span></h4>
                                    <p style="text-align: center"><a href="#">See More &rarr;</a></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
