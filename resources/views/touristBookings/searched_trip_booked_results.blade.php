@extends('layouts.main', ['title' => 'Bookings', 'header' => 'Bookings'])

@push('after-styles')
    {{ Html::style(url('vendor/select2/css/select2.min.css')) }}

@endpush
@section('content')
    <div class="container">
        <div class="content-body">
            <form class="search-bar" type="get" action="{{route('touristBookings.search_Trip_booked')}}">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="search" id="form1" name="search" class="form-control" placeholder="Search Trip Record"/>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            <p style="font-size: 15px;">Search results</p>
            <div class="row" style="padding-top: 20px">
                <div class="col-md-9">
                    @if(!empty($tourist_bookings) && $tourist_bookings->count())
                    @foreach($tourist_bookings as $tourist_booking)
                        <div class="card" style="border: 2px solid gainsboro">
                            <div class="card-body">
                                <div class="end_contents" style="border-bottom: 1px solid gainsboro">
                                    <img src="{{asset('public/logo_uploads/Logo/'.$tourist_booking->logo)}}"
                                         style="width:70px;height:70px">
                                    <h4 style="padding-left: 10px">Trip with {{$tourist_booking->company_name}}</h4>
                                    <a href="#" style="float:right">Print Record &darr;</a>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div style="position:relative">
                                                    <a href="#">Request Accommodation</a>
                                                    <a href="{{route('payments.show',$tourist_booking->uuid)}}" style="float:right"><span class="badge badge-success"> Payment history&rarr;</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div style="padding-top:5px;border-bottom: 1px solid gainsboro">
                                    <table class="table table-hover table-responsive-md">
                                        <tr>
                                            <th>Tourist name</th>
                                            <td>{{$tourist_booking->tourist_name}}</td>
                                            <th>Tourist nation</th>
                                            <td>{{$tourist_booking->nation_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>No.Travellers</th>
                                            <td>{{$tourist_booking->number_of_tourists}}</td>
                                            <th>Trip to</th>
                                            <td>{{$tourist_booking->attraction_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Start date</th>
                                            <td>{{date('jS M Y',strtotime($tourist_booking->start_date))}}</td>
                                            <th>End date</th>
                                            <td>{{date('jS M Y',strtotime($tourist_booking->end_date))}}</td>
                                        </tr>
                                        <tr>
                                            <th>Trip cost</th>
                                            @if ($tourist_booking->tourist_nation==1)
                                                <td>{{number_format(Auth::user()->getTripCostLocal($tourist_booking))}}
                                                    shillings
                                                </td>
                                            @else
                                                <td>
                                                    ${{number_format(Auth::user()->getTripCostForeigner($tourist_booking))}}
                                                    USD
                                                </td>
                                            @endif
                                            <th>Days</th>
                                            <td>{{Auth::user()->getNumberOfDays($tourist_booking)}} days</td>
                                        </tr>
                                        <tr>
                                            <th>Reserve percent</th>
                                            <td>{{Auth::user()->getDisplayGuaranteePercent($tourist_booking)}}%</td>
                                            <th>Reserve amount</th>
                                            @if($tourist_booking->tourist_nation==1)
                                                <td> {{number_format(Auth::user()->getGuaranteeAmountToBePayedLocal($tourist_booking))}}
                                                    shillings
                                                </td>
                                            @else
                                                <td>
                                                    ${{number_format(Auth::user()->getGuaranteeAmountToBePayedForeigner($tourist_booking))}}
                                                    USD
                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>Reserve status</th>

                                            @if($tourist_booking->tourist_nation==1)
                                                @if(Auth::user()->getAmountPaid($tourist_booking)>=Auth::user()->getGuaranteeAmountToBePayedLocal($tourist_booking))
                                                    <td><span class="badge badge-success">Success</span></td>
                                                @else
                                                    <td><span class="badge badge-info">Pending</span></td>
                                                @endif
                                            @else
                                                @if(Auth::user()->getAmountPaid($tourist_booking)>=Auth::user()->getGuaranteeAmountToBePayedForeigner($tourist_booking))
                                                    <td><span class="badge badge-success">Success</span></td>
                                                @else
                                                    <td><span class="badge badge-info">Pending</span></td>
                                                @endif
                                            @endif
                                            <th>Amount Paid</th>
                                            @if($tourist_booking->tourist_nation==1)
                                                <td>{{number_format(Auth::user()->getAmountPaid($tourist_booking))}} Shillings</td>
                                            @else
                                                <td>${{number_format(Auth::user()->getAmountPaid($tourist_booking))}} USD</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>Number of transactions</th>
                                            <td>{{Auth::user()->getNumberOfTransactions($tourist_booking)}}</td>
                                            <th>Remaining Amount</th>
                                            @if($tourist_booking->tourist_nation==1)
                                                <td>{{number_format((Auth::user()->getTripCostLocal($tourist_booking))-(Auth::user()->getAmountPaid($tourist_booking)))}} Shillings</td>
                                            @else
                                                <td>{{number_format((Auth::user()->getTripCostForeigner($tourist_booking))-(Auth::user()->getAmountPaid($tourist_booking)))}} USD</td>
                                            @endif


                                        </tr>
                                        <tr>
                                            <th>Payment status</th>
                                            @if($tourist_booking->tourist_nation==1)
                                                @if(Auth::user()->getAmountPaid($tourist_booking) < Auth::user()->getTripCostLocal($tourist_booking))
                                                    <td><span class="badge badge-info">Incomplete</span></td>
                                                @else
                                                    <td><span class="badge badge-success">Complete</span></td>
                                                @endif
                                            @else
                                                @if(Auth::user()->getAmountPaid($tourist_booking) < Auth::user()->getTripCostForeigner($tourist_booking))
                                                    <td><span class="badge badge-info">Incomplete</span></td>
                                                @else
                                                    <td><span class="badge badge-success">Complete</span></td>
                                                @endif
                                            @endif
                                            <th>Exceeded Amount</th>

                                            @if($tourist_booking->tourist_nation==1)
                                                <td>{{number_format((Auth::user()->getAmountPaid($tourist_booking))- (Auth::user()->getTripCostLocal($tourist_booking)))}} Shillings</td>
                                            @else
                                                <td>{{number_format((Auth::user()->getAmountPaid($tourist_booking)) - (Auth::user()->getTripCostForeigner($tourist_booking)))}} USD</td>
                                            @endif

                                        </tr>
                                        <tr>
                                            <th>Due payment</th>
                                            <td>{{$tourist_booking->payment_range}}</td>
                                            <th>Trip status</th>
                                            @if($tourist_booking->status==0)
                                                <td><span class="badge badge-pill badge-warning">Yet to be approved</span></td>
                                            @else
                                                <td><span class="badge badge-pill badge-success">Approved</span></td>
                                            @endif
                                        </tr>
                                    </table>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                {{--                                                First inner container--}}
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                @if($tourist_booking->status==0)
                                                                    <td><a href="#"
                                                                           onclick="alert('You are not legible to rate the tour operator. Seems you have not conducted a safari with this tour operator. Please wait!')">
                                                                            <button type="button" class="btn btn-primary btn-sm">Rate</button>
                                                                        </a></td>
                                                                    <td>

                                                                        @else
                                                                            <button class="btn btn-primary btn-sm rate_button"
                                                                                    value="{{$tourist_booking->id}}">Rate
                                                                            </button>
                                                                    </td>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <a href="mailto:info@kytotz.com">
                                                                    <button class="btn btn-warning btn-sm">Report</button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                @if($tourist_booking->status==0)
                                                                    <a href="{{route('touristBookings.edit',$tourist_booking->uuid)}}"><button class="btn btn-group-toggle">Adjust</button></a>
                                                                @else
                                                                    <a href="#" onclick="alert('Sorry you cannot make changes when the trip is approved. Contact the tour operator to request change')">Adjust</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                @if($tourist_booking->status==1)
                                                                    @if($tourist_booking->tourist_nation==1)
                                                                        @if(((Auth::user()->getAmountPaid($tourist_booking)) >= (Auth::user()->getTripCostLocal($tourist_booking))))
                                                                            <a href="#" onclick="alert('Congrats! Payment complete. No more payment service for this trip')">
                                                                                <button class="btn btn-info btn-sm">Pay Bill</button>
                                                                            </a>
                                                                        @elseif(((Auth::user()->getAmountPaidNonVerifiedAndVerified($tourist_booking))>=(Auth::user()->getTripCostLocal($tourist_booking))))
                                                                            <a href="#" onclick="alert('Seems the transactions done are enough for this trip cost. Please wait for your transactions to be verified')">
                                                                                <button class="btn btn-info btn-sm">Pay Bill</button>
                                                                            </a>
                                                                        @else
                                                                            <a href="{{route('payments.create',$tourist_booking->uuid)}}">
                                                                                <button class="btn btn-info btn-sm">Pay Bill</button>
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        @if(((Auth::user()->getAmountPaid($tourist_booking)) >= (Auth::user()->getTripCostForeigner($tourist_booking))))
                                                                            <a href="#" onclick="alert('Congrats! Payment complete. No more payment service for this trip')">
                                                                                <button class="btn btn-info btn-sm">Pay Bill</button>
                                                                            </a>
                                                                        @elseif(((Auth::user()->getAmountPaidNonVerifiedAndVerified($tourist_booking))>=(Auth::user()->getTripCostForeigner($tourist_booking))))
                                                                            <a href="#" onclick="alert('Seems the transactions done are enough for this trip cost. Please wait for your transactions to be verified')">
                                                                                <button class="btn btn-info btn-sm">Pay Bill</button>
                                                                            </a>
                                                                        @else
                                                                            <a href="{{route('payments.create',$tourist_booking->uuid)}}">
                                                                                <button class="btn btn-info btn-sm">Pay Bill</button>
                                                                            </a>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    <a href="#" onclick="alert('You are only allowed to pay the bill when you are verified to pay by the tour operator.Please wait!')">Pay bill</a>
                                                                @endif

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div>
                                                        <p style="font-family: sans-serif, Verdana;font-size:15px">"Payments are to be verified first. Do not worry when your payments do not auto sum into your trip card"</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    </div>

                                </div>

                                <div class="container">
                                    <!-- Trigger the modal with a button -->

                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal{{$tourist_booking->id}}"
                                         role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="row" style="display: flex">
                                                        <div class="col-md-2">
                                                            <img src="{{asset('public/logo_uploads/Logo/'.$tourist_booking->logo)}}"
                                                                 style="height:50px;width:50px;border-radius: 50%">
                                                        </div>
                                                        <div class="col-md-10" style="top:-10px;padding-left: 30px">
                                                            <h4>{{$tourist_booking->company_name}}</h4>
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
                                                           value="{{$tourist_booking->id}}" hidden>
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
                    @else
                        <span>Whoops, No items found !!</span>
                    @endif


                </div>

                <div class="col-md-3">
                    <div class="card" style="border: 2px solid gainsboro">
                        <div class="card-body">
                            <div class="col-lg-14">
                                <div class="heading">
                                    <h4><b>Booking summary</b></h4>
                                    <hr>
                                    <h4 style="font-family: sans-serif, Verdana">Trips booked ~ <span class="badge badge-info">{{Auth::user()->getUserTourBookings()->count()}}</span></h4>
                                    <h4 style="font-family: sans-serif, Verdana">Trips approved ~ <span class="badge badge-info">{{Auth::user()->getUserTourBookings()->where('status','=',1)->count()}}</span></h4>
                                    <h4 style="font-family: sans-serif, Verdana">Trips unapproved ~ <span class="badge badge-info">{{Auth::user()->getUserTourBookings()->where('status','=',0)->count()}}</span></h4>
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
            $(function () {

                $('.rate_button').on('click', function (e) {
                    e.preventDefault();
                    var id = $(this).val();
                    $('#operator_inputs').empty()

                    $('#operator_inputs').append(
                        $('<input>', {
                            type: 'text',
                            value: id,
                            name: 'tour_operators_id',
                            hidden: true
                        }))

                    $('#myModal' + id).modal("show")
                })
            })

        </script>

    @endpush

@endsection
