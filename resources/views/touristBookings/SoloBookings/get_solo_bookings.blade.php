<table class="table table-hover table-responsive-md" id="solo_trip_bookings_table">
    <thead>
    <tr>

        <th>@lang('Trip code')</th>
        <th>@lang('Trip Group')</th>
        <th>@lang('Tourist name')</th>
        <th>@lang('Phone number')</th>
        <th>@lang('Email address')</th>
        <th>@lang('Tourist nation')</th>
        <th>@lang('Number of Travellers')</th>
        <th>@lang('Start date')</th>
        <th>@lang('End date')</th>
        <th>@lang('Tourist request')</th>
    </tr>
    </thead>
</table>

@push('after-scripts')

    <script  type="text/javascript">

        $(function() {
            var url = "{{ url("/") }}";
            $('#solo_trip_bookings_table').DataTable({
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

                ajax: '{{ route('soloBookings.get_solo_bookings',$tour_operator->id) }}',
                columns: [
                    { data: 'trip_code', name: 'trip_code', orderable: true, searchable: true},
                    { data: 'group_travel_category', name: 'group_travel_category', orderable: true, searchable: true},
                    { data: 'tourist_name', name: 'tourist_name', orderable: true, searchable: true},
                    { data: 'phone_number', name: 'phone_number', orderable: true, searchable: true},
                    { data: 'email_address', name: 'email_address', orderable: true, searchable: true},
                    { data: 'tourist_nation', name: 'tourist_nation', orderable: true, searchable: true},
                    { data: 'number_of_tourists', name: 'number_of_tourists', orderable: true, searchable: false},
                    { data: 'start_date', name: 'start_date', orderable: false, searchable: true},
                    { data: 'end_date', name: 'end_date', orderable: false, searchable: true},
                    { data: 'tourist_request', name: 'tourist_request', orderable: false, searchable: false},
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $(nRow).click(function () {
                        document.location.href = url + "/admin/user_manage/edit_system_user/" + aData['uuid'] ;
                    }).hover(function () {
                        $(this).css('cursor', 'pointer');
                    }, function () {
                        $(this).css('cursor', 'auto');
                    });
                }


            });
        });

    </script>

@endpush
