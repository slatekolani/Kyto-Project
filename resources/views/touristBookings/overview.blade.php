@extends('layouts.main', ['title' => $tour_operator->company_name, 'header' => 'Company Custom Trip bookings overview'])

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
                <div class="row" style="padding-top: 40px">
                    <div class="col-md-12">
                        <h3 style="font-family:sans-serif, Verdana">Today Overview</h3>
                        <div class="card" style="border: 2px solid gainsboro">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <table class="table table-hover table-responsive-md" style="width: 80%;text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>Bookings</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="badge badge-pill">{{$company_bookings_daily}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-4">
                                        <table class="table table-hover table-responsive-md" style="width: 80%;text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>Bookings Approved</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="badge badge-pill">{{$company_approved_bookings_daily}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-4">
                                        <table class="table table-hover table-responsive-md" style="width: 80%;text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>Bookings Unapproved</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="badge badge-pill">{{$company_unapproved_bookings_daily}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top: 40px;">
                    <div class="col-md-12">
                        <h3 style="font-family:sans-serif, Verdana">Recent Week Overview</h3>
                        <div class="card" style="border: 2px solid gainsboro">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <table class="table table-hover table-responsive-md" style="width: 80%;text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>Bookings</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="badge badge-pill">{{$company_bookings_weekly}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        <table class="table table-hover table-responsive-md" style="width: 80%;text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>Approved Booking</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="badge badge-pill">{{$company_approved_bookings_weekly}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-4">
                                        <table class="table table-hover table-responsive-md" style="width: 80%;text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>Unapproved Booking</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="badge badge-pill">{{$company_unapproved_bookings_weekly}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h3 style="font-family:sans-serif, Verdana">Monthly Overview</h3>

                        <div class="card" style="border: 2px solid gainsboro">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <table class="table table-hover table-responsive-md" style="width: 80%;text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>Month</th>
                                                <th>Bookings</th>
                                                <th>Source</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            @if(!empty($total_company_monthly_bookings) && $total_company_monthly_bookings->count())
                                                @foreach($total_company_monthly_bookings as $total_company_monthly_booking)
                                                    <tbody>
                                                    <tr>
                                                        <td><span class="badge badge-light">{{$total_company_monthly_booking->month_name}}</span></td>
                                                        <td><span class="badge badge-pill">{{$total_company_monthly_booking->total_monthly_bookings}}</span></td>
                                                        <td><span class="badge badge-pill">Automated</span></td>
                                                    </tr>
                                                    </tbody>
                                                @endforeach
                                            @else
                                                <span style="float:right">No bookings made in this company yet</span>
                                                @endif
                                            </tr>
                                            </tbody>

                                        </table>
                                     </div>

                                    <div class="col-md-4">
                                        <table class="table table-hover table-responsive-md" style="width: 80%;text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>Month</th>
                                                <th>Approved</th>
                                                <th>Source</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            @if(!empty($company_bookings_verified) && $company_bookings_verified->count())
                                                @foreach($company_bookings_verified as $company_booking_verified)
                                                    <tbody>
                                                    <tr>
                                                        <td><span class="badge badge-light">{{$company_booking_verified->month_name}}</span></td>
                                                        <td><span class="badge badge-pill">{{$company_booking_verified->total_verified}}</span></td>
                                                        <td><span class="badge badge-pill">Automated</span></td>
                                                    </tr>
                                                    </tbody>
                                                @endforeach
                                            @else
                                                <span style="float:right">No bookings made in this company yet</span>
                                                @endif
                                            </tr>
                                            </tbody>

                                        </table>
                                     </div>

                                    <div class="col-md-4">
                                        <table class="table table-hover table-responsive-md" style="width: 80%;text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>Month</th>
                                                <th>Unapproved</th>
                                                <th>Source</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            @if(!empty($company_bookings_unverified) && $company_bookings_unverified->count())
                                                @foreach($company_bookings_unverified as $company_booking_unverified)
                                                    <tbody>
                                                    <tr>
                                                        <td><span class="badge badge-light">{{$company_booking_unverified->month_name}}</span></td>
                                                        <td><span class="badge badge-pill">{{$company_booking_unverified->total_unverified}}</span></td>
                                                        <td><span class="badge badge-pill">Automated</span></td>
                                                    </tr>
                                                    </tbody>
                                                @endforeach
                                            @else
                                                <span style="width:100%" class="badge badge-success">null</span>
                                                @endif
                                                </tr>
                                                </tbody>

                                        </table>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top: 40px">
                    <div class="col-md-12">
                        <h3 style="font-family:sans-serif, Verdana">Recent Year Overview</h3>
                        <div class="card" style="border: 2px solid gainsboro">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <table class="table table-hover table-responsive-md" style="width: 80%;text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>Bookings</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="badge badge-pill">{{$company_bookings_yearly}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-4">
                                        <table class="table table-hover table-responsive-md" style="width: 80%;text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>Bookings Approved</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="badge badge-pill">{{$company_approved_bookings_yearly}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-4">
                                        <table class="table table-hover table-responsive-md" style="width: 80%;text-align: center;">
                                            <thead>
                                            <tr>
                                                <th>Bookings Unapproved</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="badge badge-pill">{{$company_unapproved_bookings_yearly}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
<script>
    import Theme from "../../../public/vendor/codemirror/demo/theme.html";
    export default {
        components: {Theme}
    }
</script>
