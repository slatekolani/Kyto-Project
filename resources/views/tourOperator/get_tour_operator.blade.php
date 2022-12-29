<table class="table table-hover table-responsive-md" id="tour_operators" >
    <thead>
    <tr>
        <th>@lang('logo')</th>
        <th>@lang('company name')</th>
        <th>@lang('phone number')</th>
        <th>@lang('email address')</th>
        <th>@lang('Date of join')</th>
        <th>@lang('company nation')</th>
        <th>@lang('company_website_url')</th>
        <th>@lang('company_instagram_url')</th>
        <th>@lang('GPS')</th>
        <th>@lang('WhatsApp link')</th>
        @if(Auth::user()->hasRole(1))
        <th>@lang('Activate company')</th>
        @endif
        <th>@lang('status')</th>
        <th>@lang('Interact')</th>
    </tr>
    </thead>
</table>

@push('after-scripts')

    <script  type="text/javascript">

        $(function() {
            var url = "{{ url("/") }}";
            var table=$('#tour_operators').DataTable({
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

                ajax: '{{ route('tourOperator.get_tour_operator') }}',
                columns: [
                    // { data: 'logo', name: 'tour_operators.logo', orderable: false, searchable: false,visible:false },
                    {
                        // "data": ["image","file"],


                        "render": function (data,type,row) {
                            return`
    ${'<img src="'+row.logo+'" class="avatar" width="50" height="50" style="border-radius:50%"/>'}
            `
                        },
                    },
                    { data: 'company_name', name: 'company_name', orderable: true, searchable: true},
                    { data: 'phone_number', name: 'phone_number', orderable: false, searchable: true},
                    {data:'email_address',name:'email_address',orderable: false,searchable: true},
                    {data:'date_of_joining',name:'date_of_joining',orderable: false,searchable: true},
                    {data:'company_nation',name:'company_nation',orderable: true,searchable: true},
                    {data:'company_instagram_url',name:'company_instagram_url',orderable: true,searchable: true},
                    {data:'company_website_url',name:'company_website_url',orderable: true,searchable: true},
                    {data:'GPS_link',name:'GPS_link',orderable: true,searchable: false},
                    {data:'whatsapp_direct_link',name:'whatsapp_direct_link',orderable: true,searchable: false},
                    @if(Auth::user()->hasRole(1))
                    { data : "activate_company", "className": "text-center",
                        render: function(data, type, row, meta){
                            return  `
                           <div class="btn-group flex-wrap pull-right">

                            ${(row.status == 1) ?
                                `   <label class="switch">
                                <input type="checkbox" id="activate_company_status" checked>
                            <span class="slider round"></span>
                            </label>` :
                                `   <label class="switch">
                                <input type="checkbox" id="activate_company_status">
                            <span class="slider round"></span>
                            </label>`}
&nbsp; &nbsp;
        </div>`
                        }
                    },
                    @endif
                    { data: 'company_status', name: 'company_status', orderable: true, searchable: true},
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
            $(document).on('click','#activate_company_status',function(){
                var data = table.row( $(this).parents('tr') ).data();
                var status  = data.status
                var id = data.id
                $.ajax({
                    type: "GET",
                    dataType: "JSON",
                    url: '{{route('tourOperator.activateCompanyStatus')}}',
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
