<table class="table table-hover table-responsive-md" id="tourist_attraction">
    <thead>
    <tr>
        <th>@lang('Tourist attractions')</th>
        <th>@lang('Description')</th>
        <th>@lang('Activate tourist attraction')</th>
        <th>@lang('status')</th>
        <th>@lang('action')</th>
    </tr>
    </thead>
</table>

@push('after-scripts')

    <script  type="text/javascript">

        $(function() {
            var url = "{{ url("/") }}";
            var table=$('#tourist_attraction').DataTable({
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

                ajax: '{{ route('touristAttraction.get_tourist_attractions') }}',
                columns: [
                    { data: 'attraction_name', name: 'attraction_name', orderable: true, searchable: true},
                    { data: 'description', name: 'description', orderable: true, searchable: true},
                    { data : "activate_tourist_attraction", "className": "text-center",
                        render: function(data, type, row, meta){
                            return  `
                           <div class="btn-group flex-wrap pull-right">

                            ${(row.status == 1) ?
                                `   <label class="switch">
                                <input type="checkbox" id="activate_tourist_attraction" checked>
                            <span class="slider round"></span>
                            </label>` :
                                `   <label class="switch">
                                <input type="checkbox" id="activate_tourist_attraction">
                            <span class="slider round"></span>
                            </label>`}
&nbsp; &nbsp;
        </div>`
                        }
                    },
                    { data: 'tourist_attraction_status', name: 'tourist_attraction_status', orderable: true, searchable: true},
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

            $(document).on('click','#activate_tourist_attraction',function(){
                var data = table.row( $(this).parents('tr') ).data();
                var status  = data.status
                var id = data.id
                $.ajax({
                    type: "GET",
                    dataType: "JSON",
                    url: '{{route('touristAttraction.activateTouristAttraction')}}',
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
