@extends('layouts.main', ['title' => __("Tourist attractions"), 'header' => trans("Tourist Attractions")])

@include('includes.validate_assets')



@section('content')

    {{ Form::model($tourist_attraction,['route' => ['touristAttraction.update', $tourist_attraction->uuid], 'method'=>'put','autocomplete' => 'off',
                 'id' => 'update','class' => 'form-horizontal  needs-validation', 'novalidate']) }}
    {{ Form::hidden('id', $tourist_attraction->id, []) }}
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
                                {{ Form::label('attraction_name', __("Tourist Attraction"), ['class' => 'required_asterik']) }}
                                {{ Form::text('attraction_name', $tourist_attraction->attraction_name, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'attraction_name', 'required']) }}
                                {!! $errors->first('attraction_name', '<span class="badge badge-danger">:message</span>')!!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('description', __("Short description"), ['class' => 'required_asterik']) }}
                                {{ Form::text('description', $tourist_attraction->description, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'attraction_name', 'required']) }}
                                {!! $errors->first('description', '<span class="badge badge-danger">:message</span>')!!}
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
