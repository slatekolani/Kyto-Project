@extends('layouts.main', ['title' => __("Tanzania Tour Operator"), 'header' => trans("Tanzania Tour Operator")])

@include('includes.validate_assets')



@section('content')

    {{ Form::open(['enctype="multipart/form-data"','route' => 'tourOperator.store', 'autocomplete' => 'off','method' => 'post', 'class' => 'needs-validation', 'novalidate']) }}

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
                                {{ Form::label('company_name', __("Company name"), ['class' => 'required_asterik']) }}
                                {{ Form::text('company_name', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'company_name', 'required']) }}
                                {!! $errors->first('company_name', '<span class="badge badge-danger">:message</span>')!!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('phone_number', __("Phone number"), ['class' => 'required_asterik']) }}
                                {{ Form::tel('phone_number', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'phone_number', 'required']) }}
                                <small id="phoneHelp" class="form-text text-muted">Valid phone number for tourists to reach you</small>
                                {!! $errors->first('phone_number', '<span class="badge badge-danger">:message</span>') !!}
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
                                {{ Form::label('email_address', __("Email address"), ['class' => 'required_asterik']) }}
                                {{ Form::email('email_address', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'email_address', 'aria-describedby' => 'emailHelp', 'required']) }}
                                <small id="emailHelp" class="form-text text-muted">{{ __("Valid email address for tourists to reach you") }}</small>
                                {!! $errors->first('email_address', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('company_nation', __("Company nation"), ['class' => 'required_asterik']) }}
                                {{ Form::select('company_nation',$nation, null, ['class' => 'form-control select2', 'autocomplete' => 'off', 'id' => 'company_nation',  'required']) }}
                                {!! $errors->first('company_nation', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        {{--Left--}}

                        <table>
                            <thead>
                            <tr>
                                <th>Company Operating Regions</th>
                                <th>Company Address</th>
                                <th>Company Contact</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td> <input class="form-control" type="text" name="company_operating_regions1" required></td>
                                <td><input class="form-control" type="text" name="company_address1" required></td>
                                <td><input class="form-control" type="text" name="company_contact1" required><td>
                                <td><a class="badge badge-primary btn-lg" id="addAddress" style="cursor:pointer"><b>+</b>Add</a></td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        {{--Left--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('company_website_url', __("Website URL"), ['class' => '']) }}
                                {{ Form::url('company_website_url', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'company_website_url', 'placeholder'=>'http://kytotz.com','required']) }}
                                {!! $errors->first('company_website_url', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>

                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('company_instagram_url', __("Instagram URL"), ['class' => 'required_asterik']) }}
                                {{ Form::url('company_instagram_url', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'company_instagram_url', 'placeholder'=>'https://www.instagram.com/kytotz/','required']) }}
                                {!!  $errors->first('company_instagram_url', '<span class="badge badge-danger">:message</span>') !!}
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
                                {{ Form::label('GPS_link', __("GPS URL"), ['class' => '']) }}
                                {{ Form::url('GPS_link', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'GPS_link','required']) }}
                                {!! $errors->first('GPS_link', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>

                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('whatsapp_direct_link', __("WhatsApp link"), ['class' => 'required_asterik']) }}
                                {{ Form::url('whatsapp_direct_link', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'whatsapp_direct_link', 'required']) }}
                                {!!  $errors->first('whatsapp_direct_link', '<span class="badge badge-danger">:message</span>') !!}
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
                                {{ Form::label('logo', __("Company Logo"), ['class' => 'required_asterik']) }}
                                {{ Form::file('logo', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'logo', 'required']) }}
                                {!!  $errors->first('logo', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>

                        {{--Right--}}

{{--                        Empty field--}}


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
                            {{ Form::button(trans('Proceed'), ['class' => 'btn btn-primary', 'type'=>'submit', 'style' => 'border-radius: 5px;']) }}
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

{{--Scripts for adding address--}}
@push('after-scripts')
    <script>
        $(document).ready(function (){

            var i=1;
            $('#addAddress').on('click',function (){
                i++;
                var html='';
                html+='<tr>';
                html+='<td><input class="form-control" type="text" name="company_operating_regions'+i+'" required></td>';
                html+='<td><input class="form-control" type="text" name="company_address'+i+'" required></td>';
                html+='<td><input class="form-control" type="text" name="company_contact'+i+'" required></td>';
                html+='<td><a class="badge badge-danger btn-lg" id="removeAddress" style="cursor:pointer"><b>-</b>Remove</a></td>'
                html+='</tr>';
                $('tbody').append(html);
            })
        })
        $(document).on('click','#removeAddress',function(){
            $(this).closest('tr').remove();
        });
    </script>
@endpush
