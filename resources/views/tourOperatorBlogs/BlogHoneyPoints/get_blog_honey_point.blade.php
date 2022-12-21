<table class="table table-hover table-responsive-md" id="tour_operator_blogs_honey_point">
    <thead>
    <tr>
        <th>@lang('Image')</th>
        <th>@lang('Honey Point')</th>
        <th>@lang('Description')</th>
    </tr>
    </thead>
</table>

@push('after-scripts')

    <script  type="text/javascript">

        $(function() {
            var url = "{{ url("/") }}";
            $('#tour_operator_blogs_honey_point').DataTable({
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

                ajax: '{{ route('tourOperatorBlogHoneyPoints.get_honey_points',$tour_operator_blog->id) }}',
                columns: [
                    // { data: 'logo', name: 'tour_operators_blogs.blog_topic_image', orderable: false, searchable: false,visible:false },
                    {
                        // "data": ["image","file"],


                        "render": function (data,type,row) {
                            return`
    ${'<img src="'+row.honey_point_image+'" class="avatar" width="50" height="50" style="border-radius:50%"/>'}
            `
                        },
                    },
                    { data: 'honey_point', name: 'honey_point', orderable: true, searchable: true},
                    { data: 'honey_point_description', name: 'honey_point_description', orderable: true, searchable: true},
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
