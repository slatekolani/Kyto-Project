<table class="table table-hover table-responsive-md" id="tour_operator_service">
    <thead>
    <tr>
        <th>@lang('Image')</th>
        <th>@lang('Service')</th>
        <th>@lang('Description')</th>
    </tr>
    </thead>
</table>

@push('after-scripts')

    <script  type="text/javascript">

        $(function() {
            var url = "{{ url("/") }}";
            $('#tour_operator_service').DataTable({
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

                ajax: '{{ route('tourOperatorBlogServices.get_services',$tour_operator_blog->id) }}',
                columns: [
                    // { data: 'logo', name: 'tour_operators_blogs.blog_topic_image', orderable: false, searchable: false,visible:false },
                    {
                        // "data": ["image","file"],


                        "render": function (data,type,row) {
                            return`
    ${'<img src="'+row.service_image+'" class="avatar" width="50" height="50" style="border-radius:50%"/>'}
            `
                        },
                    },
                    { data: 'service_name', name: 'service_name', orderable: true, searchable: true},
                    { data: 'service_description', name: 'service_description', orderable: true, searchable: true},
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
