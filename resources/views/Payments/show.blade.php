@extends('layouts.main', ['title' => 'Payments', 'header' => 'Payments'])

@push('after-styles')
    {{ Html::style(url('vendor/select2/css/select2.min.css')) }}

@endpush
@section('content')
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-md-12">

                    <table class="table table-hover table-responsive-md">
                        <thead>
                        <tr>
                            <th>Account name</th>
                            <th>Amount</th>
                            <th>Reference</th>
                            <th>Date of payment</th>
                            <th>Payment Gateway</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                    @if(!empty($booking_payments) && $booking_payments->count())
                    @foreach($booking_payments as $booking_payment)
                        <tbody>
                        <tr>
                            <td>{{$booking_payment->account_name}}</td>
                            <td>{{$booking_payment->amount}}</td>
                            <td>{{$booking_payment->reference}}</td>
                            <td>{{date('jS M Y',strtotime($booking_payment->created_at))}}</td>
                            <td><span class="badge badge-light">{{\App\Models\paymentGateways\paymentGateways::find($booking_payment->payment_gateway)->payment_gateway_name}}</span></td>
                           <td> @if($booking_payment->status==0)
                                <span class="badge badge-info">Unchecked</span>
                            @else
                                <span class="badge badge-success">Verified</span>
                            @endif
                           </td>
                        </tr>
                        </tbody>

                    @endforeach
                    @else
                        <span style="float:right">No transactions made</span>
                    @endif

                    </table>


                </div>




            </div>
        </div>
    </div>

@endsection
