
<table class="table table-hover table-responsive-md" id="tour_operator_blogs_cost_exclusive">
    <thead>
    <tr>
        <th>@lang('Cost Exclusive')</th>
    </tr>
    </thead>
</table>

@push('after-scripts')

    <script  type="text/javascript">

        $(function() {
            var url = "{{ url("/") }}";
            $('#tour_operator_blogs_cost_exclusive').DataTable({
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

                ajax: '{{ route('tourOperatorBlogCostExclusive.get_cost_exclusive',$tour_operator_blog->id) }}',
                columns: [
                    { data: 'cost_exclusive', name: 'cost_exclusive', orderable: true, searchable: true},
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
