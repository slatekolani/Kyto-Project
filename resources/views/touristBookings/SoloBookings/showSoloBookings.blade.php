@extends('layouts.main', ['title' => 'Bookings', 'header' => 'Bookings'])

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
                    @foreach(Auth::user()->getUserSoloTourBookings() as $solo_booking)
                        <div class="card" style="border: 2px solid gainsboro">
                            <div class="card-body">
                                <div class="end_contents" style="border-bottom: 1px solid gainsboro">
                                    <img src="{{asset('public/logo_uploads/Logo/'.$solo_booking->tourOperators->logo)}}"
                                         style="width:70px;height:70px">
                                    <h4 style="padding-left: 10px">Trip with {{$solo_booking->tourOperators->company_name}}</h4>
                                    <a href="#" style="float:right">Print pdf invoice &darr;</a>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div style="position:relative">
                                                    <a href="{{route('soloBookingTripPals.show',$solo_booking->uuid)}}"><i class="fas fa-pen-square"></i> Trip Pals</a>
                                                    <a href="{{route('soloBookingsPayments.show',$solo_booking->uuid)}}" style="float: right"><button class="btn btn-primary btn-sm">Payment history &rarr;</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div style="padding-top:5px;border-bottom: 1px solid gainsboro">
                                    <table class="table table-hover table-responsive-md">
                                        <tr>
                                            <th>Trip Code</th>
                                            <td>{{$solo_booking->trip_code}}</td>
                                            <th>Travel Group</th>
                                            <td>{{$solo_booking->group_travel_category}}</td>
                                        </tr>
                                        <tr>
                                            <th>Tourist name/requester</th>
                                            <td>{{$solo_booking->tourist_name}}</td>
                                            <th>Tourist nation</th>
                                            <td>{{\App\Models\MemberNations\MemberNationality::find($solo_booking->tourist_nation)->nation_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Number of Travellers</th>
                                            <td>{{$solo_booking->number_of_tourists}}</td>
                                            <th>Trip to</th>
                                            <td>{{\App\Models\touristAttraction\touristAttraction::find($solo_booking->tourOperatorsBlogs->blog_topic)->attraction_name}}</td>
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
                                            <td>{{$solo_booking->tourOperatorsBlogs->payment_range}}</td>
                                        </tr>


                                    </table>

                                </div>
                                <div class="col-md-12" style="padding-top: 10px">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <button class="btn btn-primary btn-sm rate_button" value="{{$solo_booking->tourOperators->id}}">Rate</button>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="mailto:info@kytotz.com"><button class="btn btn-warning btn-sm">Report</button></a>
                                        </div>
                                        <div class="col-md-3">
                                            @if($solo_booking->status==0)
                                            <a href="{{route('soloBookings.edit',$solo_booking->uuid)}}"><button class="btn btn-group-toggle btn-sm">Adjust</button></a>
                                            @else
                                                <button class="btn btn-group-toggle btn-sm" onclick="alert('Sorry you cannot make changes when the trip is approved. Contact the tour operator to request change')">Adjust</button>
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            @if($solo_booking->status==0)
                                            <a href="{{route('soloBookingsPayments.create',$solo_booking->uuid)}}"><button class="btn btn-info btn-sm">Pay bill</button></a>
                                            @else
                                                <button class="btn btn-info btn-sm" onclick="alert('You are only allowed to pay the bill when you are verified to pay by the tour operator.Please wait!')">Pay bill</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <!-- Trigger the modal with a button -->

                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal{{$solo_booking->tourOperators->id}}"
                                         role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="row" style="display: flex">
                                                        <div class="col-md-2">
                                                            <img src="{{asset('public/logo_uploads/Logo/'.$solo_booking->tourOperators->logo)}}"
                                                                 style="height:50px;width:50px;border-radius: 50%">
                                                        </div>
                                                        <div class="col-md-10" style="top:-10px;padding-left: 30px">
                                                            <h4>{{$solo_booking->tourOperators->company_name}}</h4>
                                                        </div>

                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>

                                                </div>

                                                <div class="modal-body">
                                                    {{ Form::open([ 'route' => 'tourOperatorRating.store',  'autocomplete' => 'off','method' => 'post', 'class' => 'needs-validation', 'novalidate']) }}
                                                    <div class="form-group" id="">
                                                        {{ Form::label('comment', __("Comment Service"), ['class' => 'required_asterik']) }}
                                                        {{ Form::textarea('comment', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'comment', 'style'=>'height:200px', 'required']) }}
                                                        {!! $errors->first('comment', '<span class="badge badge-danger">:message</span>')!!}
                                                    </div>
                                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            {{ Form::label('gender', __("Gender"), ['class' => 'required_asterik']) }}
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                       name="gender" id="Male" value="Male">
                                                                <label for="Male" class="form-check-label">Male</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                       name="gender" id="Female" value="Female">
                                                                <label for="Female"
                                                                       class="form-check-label">Female</label>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <input name="tour_operators_id"
                                                           value="{{$solo_booking->tourOperators->id}}" hidden>
                                                    <div class="form-group" id="operator_inputs">

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="element-form">
                                                                <div class="form-group pull-left">
                                                                    <button type="submit" class="btn btn-primary">Rate
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger"
                                                                            data-dismiss="modal">Close
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{ Form::close() }}

                                                </div>
                                                <div class="modal-footer">
                                                    <a href="mailto:info@kytotz.com">Report</a>

                                                    <span>"Verified Tanzanian Tour Operator"</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach


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
    @push('after-scripts')
        <script>
            $(function (){
                $('.rate_button').on('click',function (e)
                {
                    e.preventDefault();
                    var id=$(this).val();
                    $('#operator_inputs').empty()

                    $('#operator_inputs').append(
                        $('<input>',{
                            text: 'text',
                            value: id,
                            name:'tour_operators_id',
                            hidden:true
                        })
                    )
                    $('#myModal' + id).modal("show")
                })
            })
        </script>
    @endpush

@endsection
