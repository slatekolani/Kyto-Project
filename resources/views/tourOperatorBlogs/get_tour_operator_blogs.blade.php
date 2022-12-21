<table class="table table-hover table-responsive-md" id="tour_operator_blogs">
    <thead>
    <tr>
        <th>@lang('Blog Image')</th>
        <th>@lang('Topic')</th>
        <th>@lang('Visit cost (local)')</th>
        <th>@lang('Visit cost (foreigner)')</th>
        <th>@lang('Guarantee percentage')</th>
        <th>@lang('Maximum travellers')</th>
        <th>@lang('Minimum travellers')</th>
        <th>@lang('Payment condition')</th>
        <th>@lang('Trip description')</th>
        <th>@lang('Trip advisor')</th>
        <th>@lang('Tour type')</th>
        <th>@lang('Transport offered')</th>
        <th>@lang('Special care')</th>
        @if(Auth::user()->hasRole(1))
        <th>@lang('Enable blog')</th>
        @endif
        <th>@lang('Status')</th>
        <th>@lang('Actions')</th>
    </tr>
    </thead>
</table>

@push('after-scripts')

    <script  type="text/javascript">

        $(function() {
            var url = "{{ url("/") }}";
            var table=$('#tour_operator_blogs').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                searching: true,
                paging: true,
                info: true,
                stateSaveCallback: function (settings, data) {
                    localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data));
                },
                stateLoadCallback: function (settings) {
                    return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance));
                },

                ajax: '{{ route('tourOperatorBlogs.get_tour_operator_blogs',$tour_operator->id) }}',
                columns: [
                     // { data: 'logo', name: 'tour_operators_blogs.blog_topic_image', orderable: false, searchable: false,visible:false },
                    {
                        // "data": ["image","file"],


                        "render": function (data,type,row) {
                            return`
    ${'<img src="'+row.blog_topic_image+'" class="avatar" width="50" height="50" style="border-radius:50%"/>'}
            `
                        },
                    },
                    { data: 'blog_topic', name: 'blog_topic', orderable: true, searchable: true},
                    {data:'visit_cost_local',name:'visit_cost_local',orderable: true,searchable: true},
                    {data:'visit_cost_foreigner',name:'visit_cost_foreigner',orderable: true,searchable: true},
                    {data:'guarantee_percentage',name:'guarantee_percentage',orderable: true,searchable: true},
                    {data:'maximum_travellers',name:'maximum_travellers',orderable: true,searchable: true},
                    {data:'minimum_travellers',name:'minimum_travellers',orderable: true,searchable: true},
                    {data:'payment_condition',name:'payment_condition',orderable: true,searchable: true},
                    {data:'trip_description',name:'trip_description',orderable: true,searchable: true},
                    {data:'trip_advisor_link',name:'trip_advisor_link',orderable: true,searchable: true},
                    {data:'tour_type_name',name:'tour_type_name',orderable: true,searchable: true},
                    {data:'transport_offered',name:'transport_offered',orderable: true,searchable: true},
                    {data:'special_care',name:'special_care',orderable: true,searchable: true},
                    @if(Auth::user()->hasRole(1))
                    { data : "enable_blog", "className": "text-center",
                        render: function(data, type, row, meta){
                            return  `
                           <div class="btn-group flex-wrap pull-right">

                            ${(row.status == 1) ?
                                `   <label class="switch">
                                <input type="checkbox" id="enable_blog" checked>
                            <span class="slider round"></span>
                            </label>` :
                                `   <label class="switch">
                                <input type="checkbox" id="enable_blog">
                            <span class="slider round"></span>
                            </label>`}
&nbsp; &nbsp;
        </div>`
                        }
                    },
                    @endif
                    { data: 'blog_status', name: 'blog_status', orderable: true, searchable: true},
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $(nRow).click(function () {
                        // document.location.href = url + "/adminView/user_manage/edit_system_user/" + aData['uuid'] ;
                    }).hover(function () {
                        $(this).css('cursor', 'pointer');
                    }, function () {
                        $(this).css('cursor', 'auto');
                    });
                }


            });
            $(document).on('click','#enable_blog',function(){
                var data = table.row( $(this).parents('tr') ).data();
                var status  = data.status
                var id = data.id
                $.ajax({
                    type: "GET",
                    dataType: "JSON",
                    url: '{{route('tourOperatorBlogs.enableBlog')}}',
                    data: {'status': status,'id':id},
                    success: function (data) {
                        // $('#notify').fadeIn();
                        // $('#notify').css('background','green');
                        // $('#notify').text('status updated successfully');
                        // // SetTimeout(()=>{
                        // //     $('#notify').fadeOut();
                        // // });
                    }
                })
            })
        });

    </script>

@endpush
