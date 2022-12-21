@extends('layouts.main', ['title' => __("Blog"), 'header' => trans("Blog")])

@include('includes.validate_assets')



@section('content')

    {{ Form::model($tour_operator_blog,['enctype="multipart/form-data"','route' => ['tourOperatorBlogs.update', $tour_operator_blog->uuid], 'method'=>'put','autocomplete' => 'off',
          'id' => 'update','class' => 'form-horizontal  needs-validation', 'novalidate']) }}
    {{ Form::hidden('id', $tour_operator_blog->id, []) }}
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
                                {{ Form::label('blog_topic', __("Blog Topic"), ['class' => 'required_asterik']) }}
                                {{ Form::select('blog_topic', $tourist_attraction,$tourist_attraction, ['class' => 'form-control select2','autocomplete' => 'off', 'id' => 'blog_topic', 'required']) }}
                                {!! $errors->first('blog_topic', '<span class="badge badge-danger">:message</span>')!!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('blog_topic_image', __("Blog Topic Image"), ['class' => 'required_asterik']) }}
                                <img src="{{asset('public/BlogImages/topicImages/'.$tour_operator_blog->blog_topic_image)}}" style="width: 50px;height:50px">
                                {{ Form::file('blog_topic_image', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'company_team_image', 'required']) }}
                                {!!  $errors->first('blog_topic_image', '<span class="badge badge-danger">:message</span>') !!}
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
                                {{ Form::label('visit_cost_foreigner', __("Cost of Visit per person (Foreigner)"), ['class' => 'required_asterik']) }}
                                {{ Form::number('visit_cost_foreigner', $tour_operator_blog->visit_cost_foreigner, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder'=>'Do not use any currency symbol like $,£.','id' => 'visit_cost_foreigner', 'required']) }}
                                {!! $errors->first('visit_cost_foreigner', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('visit_cost_local', __("Cost of visit per person (Local)"), ['class' => 'required_asterik']) }}
                                {{ Form::number('visit_cost_local', $tour_operator_blog->visit_cost_local, ['class' => 'form-control', 'autocomplete' => 'off','placeholder'=>'Do not write any currency symbol like TZS','id' => 'visit_cost_local', 'required']) }}
                                {!! $errors->first('visit_cost_local', '<span class="badge badge-danger">:message</span>') !!}
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
                                {{ Form::label('maximum_travellers', __("Maximum number of travellers"), ['class' => 'required_asterik']) }}
                                {{ Form::number('maximum_travellers', $tour_operator_blog->maximum_travellers, ['class' => 'form-control', 'autocomplete' => 'off','id' => 'maximum_travellers', 'required']) }}
                                {!! $errors->first('maximum_travellers', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                        {{--Right--}}

                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('trip_advisor_link', __("Trip advisor Link for this reserve"), ['class' => 'required_asterik']) }}
                                {{ Form::url('trip_advisor_link', $tour_operator_blog->trip_advisor_link, ['class' => 'form-control', 'autocomplete' => 'off','placeholder'=>'if none type none.','id' => 'trip_advisor_link', 'required']) }}
                                {!! $errors->first('trip_advisor_link', '<span class="badge badge-danger">:message</span>') !!}
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
                                <th>Cost Inclusive</th>
                            </tr>
                            </thead>
                            <tbody id="cost_inclusive">
                            @if(!empty($tour_operator_blog_cost_inclusives) && $tour_operator_blog_cost_inclusives->count())
                                @foreach($tour_operator_blog_cost_inclusives as $tour_operator_blog_cost_inclusive)
                            <tr>
                                <td><input type="text" name="cost_inclusive1" class="form-control" value="{{$tour_operator_blog_cost_inclusive->cost_inclusive}}" required></td>
                                <td><a class="badge badge-primary btn-lg" id="addCostInclusive" style="cursor: pointer"><b>+</b>Add</a></td>
                            </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{--Right--}}
                        <table>
                            <thead>
                            <tr>
                                <th>Cost Exclusive</th>
                            </tr>
                            </thead>
                            <tbody id="cost_exclusive">
                            @if(!empty($tour_operator_blog_cost_exclusives) && $tour_operator_blog_cost_exclusives->count())
                                @foreach($tour_operator_blog_cost_exclusives as $tour_operator_blog_cost_exclusive)
                            <tr>
                                <td><input type="text" name="cost_exclusive1" class="form-control" value="{{$tour_operator_blog_cost_exclusive->cost_exclusive}}" required></td>
                                <td><a class="badge badge-primary btn-lg" id="addCostExclusive" style="cursor: pointer"><b>+</b>Add</a></td>
                            </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>


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
                                <th>Service name</th>
                                <th>Description</th>
                                <th>Image</th>
                            </tr>
                            </thead>
                            <tbody id="services">
                            @if(!empty($tour_operator_blog_services) && $tour_operator_blog_services->count())
                                @foreach($tour_operator_blog_services as $tour_operator_blog_service)
                            <tr>
                                <td><input type="text" name="service_name1" class="form-control" value="{{$tour_operator_blog_service->service_name}}" required></td>
                                <td><input type="text" name="service_description1" maxlength="500" placeholder="maximum 500 characters" class="form-control" value="{{$tour_operator_blog_service->service_description}}" required></td>
                                <img src="{{asset('public/BlogImages/serviceImages/'.$tour_operator_blog_service->service_image)}}" style="width:50px;height:50px">
                                <td><input type="file" name="service_image1" class="form-control" required></td>
                                <td><a class="badge badge-primary btn-lg" id="addService" style="cursor: pointer"><b>+</b>Add</a></td>
                            </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{--Right--}}


                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        {{--Left--}}
                        <p>Out-list the honey points and explaining the uniqueness of it, also how you operate in them to build interest of a tourist to travel with you</p>
                        <table>
                            <thead>
                            <tr>
                                <th>Honey Point</th>
                                <th>Description</th>
                                <th>Image</th>
                            </tr>
                            </thead>
                            <tbody id="honeyPoint">
                            @if(!empty($tour_operator_blog_honey_points) && $tour_operator_blog_honey_points->count())
                                @foreach($tour_operator_blog_honey_points as $tour_operator_blog_honey_point)
                            <tr>
                                <td><input type="text" class="form-control" name="honey_point1" value="{{$tour_operator_blog_honey_point->honey_point}}" required></td>
                                <td><input type="text" class="form-control" maxlength="500" placeholder="maximum 500 characters" name="honey_point_description1" value="{{$tour_operator_blog_honey_point->honey_point_description}}" required></td>
                                <img src="{{asset('public/BlogImages/honeyPointsImages/'.$tour_operator_blog_honey_point->honey_point_image)}}" style="width: 50px;height:50px">
                                <td><input type="file" class="form-control" name="honey_point_image1" required></td>
                                <td><a class="badge badge-primary btn-lg" id="addHoneyPoint" style="cursor: pointer"><b>+</b>Add</a></td>
                            </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>

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
                                <th>Trip Requirement</th>
                                <th>Why is it required?</th>
                            </tr>
                            </thead>
                            <tbody id="trip_requirement">
                            @if(!empty($tour_operator_trip_requirements) && $tour_operator_trip_requirements->count())
                                @foreach($tour_operator_trip_requirements as $tour_operator_trip_requirement)
                            <tr>
                                <td><input type="text" name="trip_requirement1" class="form-control" value="{{$tour_operator_trip_requirement->trip_requirement}}" required></td>
                                <td><input type="text" name="reason_for_requirement1" class="form-control" value="{{$tour_operator_trip_requirement->reason_for_requirement}}" required></td>
                                <td><a class="badge badge-primary btn-lg" id="addTripRequirement" style="cursor: pointer"><b>+</b>Add</a></td>
                            </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{--Right--}}



                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        {{--Left--}}



                        {{--                        right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('guarantee_percentage', __("Reserve Percentage"), ['class' => 'required_asterik']) }}
                                {{ Form::number('guarantee_percentage', null, ['class' => 'form-control', 'autocomplete' => 'off','placeholder'=>'eg.50','id' => 'guarantee_percentage', 'maxlength'=>'3','required']) }}
                                <small  class="form-text" style="color:indianred">{{ __("Please fill in value between 1 to 100. Otherwise suspicion will disappoint you.") }}</small>
                                {!! $errors->first('guarantee_percentage', '<span class="badge badge-danger">:message</span>') !!}
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
                                {{ Form::label('transport_offered', __("Transport used in a specific area"), ['class' => 'required_asterik']) }}
                                {{ Form::select('transport_offered[]', $transport_service,$transport_service_ids, ['class' => 'form-control select2', 'multiple', 'autocomplete' => 'off', 'id' => 'transport_offered', 'required']) }}
                                {!!  $errors->first('transport_offered', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>


                        {{--right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('special_care', __("Special need"), ['class' => 'required_asterik']) }}
                                {{ Form::select('special_care[]',$special_care, $special_care_ids, ['class' => 'form-control select2','multiple', 'autocomplete' => 'off','id' => 'special_care','required']) }}
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
                                {{ Form::label('tour_type_name', __("Type of tour offered in this area"), ['class' => 'required_asterik']) }}
                                {{ Form::select('tour_type_name[]',$tour_type, $tour_type_ids, ['class' => 'form-control select2','multiple', 'autocomplete' => 'off','id' => 'tour_type_name','required']) }}
                                {!! $errors->first('tour_type_name', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                        {{--                        right--}}

                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('payment_range', __("Payment range"), ['class' => 'required_asterik']) }}
                                {{ Form::text('payment_range', $tour_operator_blog->payment_range, ['class' => 'form-control', 'autocomplete' => 'off','id' => 'payment_range', 'required']) }}
                                {!! $errors->first('payment_range', '<span class="badge badge-danger">:message</span>') !!}
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
                                {{ Form::label('trip_description', __("Short trip summary"), ['class' => 'required_asterik']) }}
                                {{ Form::textarea('trip_description', $tour_operator_blog->trip_description, ['class' => 'form-control', 'autocomplete' => 'off', 'maxlength'=>'600','id' => 'trip_description','placeholder'=>'Safari will start from......', 'required']) }}
                                {!! $errors->first('trip_description', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                        {{--right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('payment_condition', __("Short payment term and condition"), ['class' => 'required_asterik']) }}
                                {{ Form::textarea('payment_condition', $tour_operator_blog->payment_condition, ['class' => 'form-control', 'autocomplete' => 'off', 'maxlength'=>'600','id' => 'payment_condition','placeholder'=>'Short summary for the payment term and condition', 'required']) }}
                                {!! $errors->first('payment_condition', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <input name="tour_operators_id" value="{{$tour_operator_blog->tourOperators->id}}" hidden>

            <br/>
            {{--Buttons--}}
            <div class="row">
                <div class="col-md-6">
                    <div class="element-form">
                        <div class="form-group pull-left">
                            {{ link_to_route('home',trans('buttons.general.cancel'),[],['id'=> 'cancel', 'class' => 'btn btn-primary cancel_button', ]) }}
                            {{ Form::button(trans('Post Blog'), ['class' => 'btn btn-primary', 'type'=>'submit', 'style' => 'border-radius: 5px;']) }}
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
{{--scripts to add service--}}
@push('after-scripts')

    <script>
        $(document).ready(function(){
            var i=1;
            $('#addService').on('click',function (){
                i++;
                var html='';
                html+='<tr>';
                html+='<td><input type="text" name="service_name'+i+'" class="form-control"></td>';
                html+='<td><textarea type="text" name="service_description'+i+'" class="form-control"></textarea></td>';
                html+='<td><input type="file" name="service_image'+i+'" class="form-control"></td>';
                html+='<td><a class="badge badge-danger" id="removeService" style="cursor: pointer"><b>-</b>Remove</a></td>';
                html+='</tr>';
                $('#services').append(html);
            })

        })
        $(document).on('click','#removeService',function (){
            $(this).closest('tr').remove();
        });
    </script>
@endpush

{{--scripts to add honeypoints--}}
@push('after-scripts')
    <script>
        $(document).ready(function (){
            var i=1;
            $('#addHoneyPoint').on('click',function(){
                i++;
                var html='';
                html+='<tr>'
                html+='<td><input type="text" class="form-control" name="honey_point'+i+'"></td>';
                html+='<td><textarea type="text" class="form-control" name="honey_point_description'+i+'"></textarea></td>';
                html+='<td><input type="file" class="form-control" name="honey_point_image'+i+'"></td>';
                html+='<td><a class="badge badge-danger btn-lg" id="removeHoneyPoint" style="cursor: pointer"><b>-</b>Remove</a></td>'
                html+='</tr>'
                $('#honeyPoint').append(html);
            })
        })
        $(document).on('click','#removeHoneyPoint',function()
        {
            $(this).closest('tr').remove();
        });
    </script>
@endpush


{{--Scripts to add cost inclusive--}}
@push('after-scripts')

    <script>
        $(document).ready(function(){
            var i=1;
            $('#addCostInclusive').on('click',function (){
                i++;
                var html='';
                html+='<tr>';
                html+='<td><input type="text" name="cost_inclusive'+i+'" class="form-control"></td>';
                html+='<td><a class="badge badge-danger" id="removeCostInclusive" style="cursor: pointer"><b>-</b>Remove</a></td>';
                html+='</tr>';
                $('#cost_inclusive').append(html);
            })

        })
        $(document).on('click','#removeCostInclusive',function (){
            $(this).closest('tr').remove();
        });
    </script>
@endpush


{{--Scripts to add cost exclusive--}}
@push('after-scripts')

    <script>
        $(document).ready(function(){
            var i=1;
            $('#addCostExclusive').on('click',function (){
                i++;
                var html='';
                html+='<tr>';
                html+='<td><input type="text" name="cost_exclusive'+i+'" class="form-control"></td>';
                html+='<td><a class="badge badge-danger" id="removeCostExclusive" style="cursor: pointer"><b>-</b>Remove</a></td>';
                html+='</tr>';
                $('#cost_exclusive').append(html);
            })

        })
        $(document).on('click','#removeCostExclusive',function (){
            $(this).closest('tr').remove();
        });
    </script>
@endpush

{{--Scripts to add Trip requirement--}}
@push('after-scripts')

    <script>
        $(document).ready(function(){
            var i=1;
            $('#addTripRequirement').on('click',function (){
                i++;
                var html='';
                html+='<tr>';
                html+='<td><input type="text" name="trip_requirement'+i+'" class="form-control"></td>';
                html+='<td><input type="text" name="reason_for_requirement'+i+'" class="form-control"></td>';
                html+='<td><a class="badge badge-danger" id="removeTripRequirement" style="cursor: pointer"><b>-</b>Remove</a></td>';
                html+='</tr>';
                $('#trip_requirement').append(html);
            })

        })
        $(document).on('click','#removeTripRequirement',function (){
            $(this).closest('tr').remove();
        });
    </script>
@endpush
