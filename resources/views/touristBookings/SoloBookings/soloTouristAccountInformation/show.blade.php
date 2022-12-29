@extends('layouts.main', ['title' => 'Account Information', 'header' => 'Account Information'])

@push('after-styles')
    {{ Html::style(url('vendor/select2/css/select2.min.css')) }}

@endpush
@section('content')
    <div class="container">
        <div class="content">
            <a href="{{route('soloTouristAccountInformation.create',$solo_booking->uuid)}}"><i class="fa fa-pencil-alt">Add Account</i></a>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body" style="border: 2px solid gainsboro">
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
                                    <th>Payment Gateway</th>
                                    <th>Account name</th>
                                    <th>Account number</th>
                                    <th>Change status</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                @if(!empty($solo_tourist_account_informations) && $solo_tourist_account_informations->count())
                                    @foreach($solo_tourist_account_informations as $solo_tourist_account_information)
                                        <tbody>
                                        <tr>
                                            <td>{{\App\Models\paymentGateways\paymentGateways::find($solo_tourist_account_information->payment_gateway)->payment_gateway_name}}</td>
                                            <td>{{$solo_tourist_account_information->account_name}}</td>
                                            <td>{{$solo_tourist_account_information->account_number}}</td>
                                            <td><label class="switch">
                                                    <input type="checkbox">
                                                    <span class="slider round"></span>
                                                </label></td>
                                            <td>
                                                @if($solo_tourist_account_information->status==0)
                                                    <span class="badge badge-danger">Inactive</span>
                                                @else
                                                    <span class="badge badge-success">Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('soloTouristAccountInformation.edit',$solo_tourist_account_information->uuid)}}" class="btn btn-primary btn-sm">Update</a>
                                                <a href="{{route('soloTouristAccountInformation.delete',$solo_tourist_account_information->uuid)}}" class="btn btn-danger btn-sm">Delete</a>
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
        </div>
    </div>

@endsection
