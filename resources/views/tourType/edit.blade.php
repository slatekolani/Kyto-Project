@extends('layouts.main', ['title' => __("Tour Type Category"), 'header' => trans("Tour Type Category")])

@include('includes.validate_assets')



@section('content')

    {{ Form::model($tour_type,['route' => ['tourType.update', $tour_type->uuid], 'method'=>'put','autocomplete' => 'off',
          'id' => 'update','class' => 'form-horizontal  needs-validation', 'novalidate']) }}
    {{ Form::hidden('id', $tour_type->id, []) }}
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
                                {{ Form::label('tour_type_name', __("Tour type name"), ['class' => 'required_asterik']) }}
                                {{ Form::text('tour_type_name', $tour_type->tour_type_name, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'tour_type_name', 'required']) }}
                                {!! $errors->first('tour_type_name', '<span class="badge badge-danger">:message</span>')!!}
                            </div>
                        </div>
                        {{--Right--}}

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
