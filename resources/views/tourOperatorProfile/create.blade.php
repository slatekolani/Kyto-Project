@extends('layouts.main', ['title' => __("Tour Operator Profile"), 'header' => trans("Tour Operator Profile")])

@include('includes.validate_assets')



@section('content')

    {{ Form::open(['enctype="multipart/form-data"','route' => 'tourOperatorProfile.store', 'autocomplete' => 'off','method' => 'post', 'class' => 'needs-validation', 'novalidate']) }}

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
                                {{ Form::textarea('about_company', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'about_company', 'required']) }}
                                {!! $errors->first('about_company', '<span class="badge badge-danger">:message</span>')!!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('company_core_values', __("Company core values"), ['class' => 'required_asterik']) }}
                                {{ Form::text('company_core_values', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'company_core_values', 'required']) }}
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
                                {{ Form::text('company_experience', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'company_experience', 'required']) }}
                                {!! $errors->first('company_experience', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
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
                                {{ Form::select('attraction_name[]',$tourist_attraction, null, ['class' => 'form-control select2', 'autocomplete' => 'off', 'multiple','id' => 'tourist_attraction', 'required']) }}
                                {!!  $errors->first('attraction_name', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('special_care', __("Special group"), ['class' => 'required_asterik']) }}
                                {{ Form::select('special_care[]',$special_care ,null, ['class' => 'form-control select2', 'autocomplete' => 'off', 'id' => 'special_care','multiple', 'required']) }}
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
                                {{ Form::select('transport_name[]',$transport_service, null, ['class' => 'form-control select2', 'autocomplete' => 'off','multiple', 'id' => 'transport_name', 'required']) }}
                                {!! $errors->first('transport_name', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
{{--                        Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('language_name', __("Language Offered"), ['class' => 'required_asterik']) }}
                                {{ Form::select('language_name[]',$language, null, ['class' => 'form-control select2', 'autocomplete' => 'off','multiple', 'id' => 'language_name', 'required']) }}
                                {!! $errors->first('language_name', '<span class="badge badge-danger">:message</span>') !!}
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
