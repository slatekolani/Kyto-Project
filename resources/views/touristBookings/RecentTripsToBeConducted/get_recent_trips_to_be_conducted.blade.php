<table class="table table-hover table-responsive-md" id="tourist_bookings_table">
    <thead>
    <tr>
        <th>@lang('Date of booking')</th>
        <th>@lang('Tourist name')</th>
        <th>@lang('Countdown days')</th>
        <th>@lang('Countdown days status')</th>
        <th>@lang('Phone number')</th>
        <th>@lang('Email address')</th>
        <th>@lang('Tourist nation')</th>
        <th>@lang('no of travellers')</th>
        <th>@lang('Trip to')</th>
        <th>@lang('Start date')</th>
        <th>@lang('End date')</th>
        <th>@lang('# days')</th>
        <th>@lang('Reserve percent')</th>
        <th>@lang('Tourist request')</th>
        <th>@lang('Confirm Trip')</th>
        <th>@lang('confirmation')</th>
        <th>@lang('# Transactions')</th>
        <th>@lang('# checked transactions')</th>
        <th>@lang('Payment status')</th>
        <th>@lang('Interact')</th>
    </tr>
    </thead>
</table>

@push('after-scripts')

    <script  type="text/javascript">

        $(function() {
            var url = "{{ url("/") }}";
            var table= $('#tourist_bookings_table').DataTable({
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

                ajax: '{{ route('touristBookings.get_recent_trips_to_be_conducted',$tour_operator->id) }}',
                columns: [
                    {data:'booked_time',name:'booked_time',orderable: true,searchable: true},
                    { data: 'tourist_name', name: 'tourist_name', orderable: true, searchable: true},
                    { data: 'countdown_days', name: 'countdown_days', orderable: true, searchable: true},
                    { data: 'countdown_days_status', name: 'countdown_days_status', orderable: true, searchable: true},
                    { data: 'phone_number', name: 'phone_number', orderable: false, searchable: true},
                    {data:'email_address',name:'email_address',orderable: false,searchable: true},
                    {data:'tourist_nation',name:'tourist_nation',orderable: true,searchable: true},
                    {data:'number_of_tourists',name:'number_of_tourists',orderable: true,searchable: true},
                    {data:'blog_topic',name:'blog_topic',orderable: true,searchable: true},
                    {data:'start_date',name:'start_date',orderable: true,searchable: true},
                    {data:'end_date',name:'end_date',orderable: true,searchable: true},
                    {data:'number_of_days',name:'number_of_days',orderable: true,searchable: true},
                    {data:'reserve_percent',name:'reserve_percent',orderable: true,searchable: true},
                    {data:'tourist_request',name:'tourist_request',orderable: true,searchable: true},
                    { data : "confirm_trip", "className": "text-center",
                        render: function(data, type, row, meta){
                            return  `
                           <div class="btn-group flex-wrap pull-right">

                            ${(row.status == 1) ?
                                `   <label class="switch">
                                <input type="checkbox" id="confirm_trip" checked>
                            <span class="slider round"></span>
                            </label>` :
                                `   <label class="switch">
                                <input type="checkbox" id="confirm_trip">
                            <span class="slider round"></span>
                            </label>`}
&nbsp; &nbsp;
        </div>`
                        }
                    },
                    { data: 'confirmation', name: 'confirmation', orderable: true, searchable: true},
                    { data: 'total_number_of_payments', name: 'total_number_of_payments', orderable: true, searchable: true},
                    { data: 'checked_payments', name: 'checked_payments', orderable: true, searchable: true},
                    { data: 'unchecked_payments', name: 'unchecked_payments', orderable: true, searchable: true},
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
            $(document).on('click','#confirm_trip',function(){
                var data = table.row( $(this).parents('tr') ).data();
                var status  = data.status
                var id = data.id
                $.ajax({
                    type: "GET",
                    dataType: "JSON",
                    url: '{{route('touristBookings.ConfirmationStatus')}}',
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
