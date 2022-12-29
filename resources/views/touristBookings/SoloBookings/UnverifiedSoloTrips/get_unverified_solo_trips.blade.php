<table class="table table-hover table-responsive-md" id="Unverified_solo_trips_table">
    <thead>
    <tr>
        <th>@lang('Date of booking')</th>
        <th>@lang('Trip status')</th>
        <th>@lang('Trip code')</th>
        <th>@lang('Trip to')</th>
        <th>@lang('Trip Group')</th>
        <th>@lang('# days')</th>
        <th>@lang('Tourist name')</th>
        <th>@lang('Phone number')</th>
        <th>@lang('Email address')</th>
        <th>@lang('Tourist nation')</th>
        <th>@lang('Number of Travellers')</th>
        <th>@lang('Start date')</th>
        <th>@lang('End date')</th>
        <th>@lang('Trip price')</th>
        <th>@lang('Countdown days')</th>
        <th>@lang('Countdown days status')</th>
        <th>@lang('Tourist request')</th>
        <th>@lang('Confirm Trip')</th>
        <th>@lang('status')</th>
        <th>@lang('# Transactions')</th>
        <th>@lang('# Checked transactions')</th>
        <th>@lang('# Unchecked transactions')</th>
        <th>@lang('Payment status')</th>
        <th>@lang('Action')</th>
    </tr>
    </thead>
</table>

@push('after-scripts')

    <script  type="text/javascript">

        $(function() {
            var url = "{{ url("/") }}";
            var table= $('#Unverified_solo_trips_table').DataTable({
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

                ajax: '{{ route('soloBookings.get_unverified_solo_trips',$tour_operator->id) }}',
                columns: [
                    { data: 'date_of_booking', name: 'date_of_booking', orderable: true, searchable: true},
                    { data: 'solo_trip_public_status', name: 'solo_trip_public_status', orderable: true, searchable: true},
                    { data: 'trip_code', name: 'trip_code', orderable: true, searchable: true},
                    { data: 'blog_topic', name: 'blog_topic', orderable: true, searchable: true},
                    { data: 'group_travel_category', name: 'group_travel_category', orderable: true, searchable: true},
                    { data: 'number_of_days', name: 'number_of_days', orderable: true, searchable: true},
                    { data: 'tourist_name', name: 'tourist_name', orderable: true, searchable: true},
                    { data: 'phone_number', name: 'phone_number', orderable: true, searchable: true},
                    { data: 'email_address', name: 'email_address', orderable: true, searchable: true},
                    { data: 'tourist_nation', name: 'tourist_nation', orderable: true, searchable: true},
                    { data: 'number_of_tourists', name: 'number_of_tourists', orderable: true, searchable: false},
                    { data: 'start_date', name: 'start_date', orderable: false, searchable: true},
                    { data: 'end_date', name: 'end_date', orderable: false, searchable: true},
                    { data: 'amount', name: 'amount', orderable: false, searchable: true},
                    { data: 'count_down_days_for_trip', name: 'count_down_days_for_trip', orderable: false, searchable: false},
                    { data: 'count_down_days_status', name: 'count_down_days_status', orderable: false, searchable: false},
                    { data: 'tourist_request', name: 'tourist_request', orderable: false, searchable: false},
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
                    { data: 'trip_confirmation', name: 'trip_confirmation', orderable: false, searchable: false},
                    { data: 'number_of_transactions', name: 'number_of_transactions', orderable: false, searchable: false},
                    { data: 'number_of_checked_transactions', name: 'number_of_checked_transactions', orderable: false, searchable: false},
                    { data: 'number_of_unchecked_transactions', name: 'number_of_unchecked_transactions', orderable: false, searchable: false},
                    { data: 'payment_status', name: 'payment_status', orderable: false, searchable: true},
                    { data: 'actions', name: 'actions', orderable: false, searchable: false},
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $(nRow).click(function () {
                        // document.location.href = url + "/admin/user_manage/edit_system_user/" + aData['uuid'] ;
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
                    url: '{{route('soloBookings.ConfirmationStatus')}}',
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
