@extends('layouts.main', ['title' => __("Tour Operator Profile"), 'header' => trans("Tour Operator Profile")])

@include('includes.validate_assets')



@section('content')

    {{ Form::model($tour_operator_profile,['enctype="multipart/form-data"','route' => ['tourOperatorProfile.update', $tour_operator_profile->uuid], 'method'=>'put','autocomplete' => 'off',
       'id' => 'update','class' => 'form-horizontal  needs-validation', 'novalidate']) }}
    {{ Form::hidden('id', $tour_operator_profile->id, []) }}
    <section class="card">
        <div class="card-body">
            <p>{{ getLanguageBlock('lang.auth.mandatory-field') }}</p>
            {{--User account type(Administrative)--}}

            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        {{--Left--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('about_company', __("About Company"), ['class' => 'required_asterik']) }}
                                {{ Form::textarea('about_company', $tour_operator_profile->about_company, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'about_company', 'required']) }}
                                {!! $errors->first('about_company', '<span class="badge badge-danger">:message</span>')!!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('company_core_values', __("Company core values"), ['class' => 'required_asterik']) }}
                                {{ Form::text('company_core_values', $tour_operator_profile->company_core_values, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'company_core_values', 'required']) }}
                                {!! $errors->first('company_core_values', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        {{--Left--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('company_experience', __("Company experience"), ['class' => '']) }}
                                {{ Form::text('company_experience', $tour_operator_profile->company_experience, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'company_experience', 'required']) }}
                                {!! $errors->first('company_experience', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <img src="{{asset('public/TeamImage/Images/'.$tour_operator->tourOperatorProfile->company_team_image)}}" style="width:50px;height:50px">
                                {{ Form::label('company_team_image', __("Team Image"), ['class' => 'required_asterik']) }}
                                {{ Form::file('company_team_image', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'company_team_image', 'required']) }}
                                {!!  $errors->first('company_team_image', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        {{--Left--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('attraction_name', __("Area of activity"), ['class' => 'required_asterik']) }}
                                {{ Form::select('attraction_name[]',$tourist_attraction, $tourist_attraction_ids, ['class' => 'form-control select2', 'autocomplete' => 'off', 'multiple','id' => 'tourist_attraction', 'required']) }}
                                {!!  $errors->first('attraction_name', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('special_care', __("Special group"), ['class' => 'required_asterik']) }}
                                {{ Form::select('special_care[]',$special_care ,$special_care_ids, ['class' => 'form-control select2', 'autocomplete' => 'off', 'id' => 'special_care','multiple', 'required']) }}
                                {!! $errors->first('special_care', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        {{--Left--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('transport_name', __("Transport offered"), ['class' => 'required_asterik']) }}
                                {{ Form::select('transport_name[]',$transport_service, $transport_service_ids, ['class' => 'form-control select2', 'autocomplete' => 'off','multiple', 'id' => 'transport_name', 'required']) }}
                                {!! $errors->first('transport_name', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                        <input name="tour_operators_id" value="{{$tour_operator->id}}" hidden>
                    </div>
                </div>
            </div>

            <br/>
            {{--Buttons--}}
            <div class="row">
                <div class="col-md-6">
                    <div class="element-form">
                        <div class="form-group pull-left">
                            {{ link_to_route('home',trans('buttons.general.cancel'),[],['id'=> 'cancel', 'class' => 'btn btn-primary cancel_button', ]) }}
                            {{ Form::button(trans('Finish'), ['class' => 'btn btn-primary', 'type'=>'submit', 'style' => 'border-radius: 5px;']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br/>
    {{ Form::close() }}
@endsection

@push('after-scripts')

    <script>
        $(function() {
            $(".select2").select2();

        });
    </script>

@endpush
