<table class="table table-hover table-responsive-md" id="tour_operator_blogs_trip_requirement">
    <thead>
    <tr>
        <th>@lang('Trip Requirement')</th>
        <th>@lang('Reason for requirement')</th>
    </tr>
    </thead>
</table>

@push('after-scripts')

    <script  type="text/javascript">

        $(function() {
            var url = "{{ url("/") }}";
            $('#tour_operator_blogs_trip_requirement').DataTable({
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

                ajax: '{{ route('tourOperatorBlogTripRequirement.get_trip_requirement',$tour_operator_blog->id) }}',
                columns: [
                    { data: 'trip_requirement', name: 'trip_requirement', orderable: true, searchable: true},
                    { data: 'reason_for_requirement', name: 'reason_for_requirement', orderable: true, searchable: true},
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
        });

    </script>

@endpush
