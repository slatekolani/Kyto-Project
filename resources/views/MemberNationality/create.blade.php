@extends('layouts.main', ['title' => __(" Member Nationality"), 'header' => trans("Member Nationality")])

@include('includes.validate_assets')



@section('content')

    {{ Form::open(['enctype="multipart/form-data"','route' => 'MemberNationality.store', 'autocomplete' => 'off','method' => 'post', 'class' => 'needs-validation', 'novalidate']) }}

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
                                {{ Form::label('nation_name', __("Nation name"), ['class' => 'required_asterik']) }}
                                {{ Form::text('nation_name', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'nation_name', 'required']) }}
                                {!! $errors->first('nation_name', '<span class="badge badge-danger">:message</span>')!!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('nation_flag', __("Nation Flag"), ['class' => 'required_asterik']) }}
                                {{ Form::file('nation_flag', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'nation_flag', 'required']) }}
                                {!! $errors->first('nation_flag', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
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
                            {{ Form::button(trans('Populate'), ['class' => 'btn btn-primary', 'type'=>'submit', 'style' => 'border-radius: 5px;']) }}
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
