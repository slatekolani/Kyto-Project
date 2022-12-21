@extends('layouts.main', ['title' => __("Languages"), 'header' => trans("Languages")])

@include('includes.validate_assets')



@section('content')

    {{ Form::model($language,['enctype="multipart/form-data"','route' => ['Language.update', $language->uuid], 'method'=>'put','autocomplete' => 'off',
                    'id' => 'update','class' => 'form-horizontal  needs-validation', 'novalidate']) }}
    {{ Form::hidden('id', $language->id, []) }}
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
                                {{ Form::label('language_name', __("Language"), ['class' => 'required_asterik']) }}
                                {{ Form::text('language_name', $language->language_name, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'language_name', 'required']) }}
                                {!! $errors->first('language_name', '<span class="badge badge-danger">:message</span>')!!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <img src="{{url('public/Languages/',$language->nation_language_flag)}}" style="width:50px;height:50px"><span>Your previous image</span>
                                {{ Form::label('nation_language_flag', __("Nation language Flag"), ['class' => 'required_asterik']) }}
                                {{ Form::file('nation_language_flag', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'nation_language_flag', 'required']) }}
                                {!! $errors->first('nation_language_flag', '<span class="badge badge-danger">:message</span>') !!}
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
