<table class="table table-hover table-responsive-md" id="payment_gateways">
    <thead>
    <tr>
        <th>@lang('Icon')</th>
        <th>@lang('name')</th>
        <th>@lang('Activate gateway')</th>
        <th>@lang('status')</th>
        <th>@lang('action')</th>
    </tr>
    </thead>
</table>

@push('after-scripts')

    <script  type="text/javascript">

        $(function() {
            var url = "{{ url("/") }}";
            var table=$('#payment_gateways').DataTable({
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

                ajax: '{{ route('paymentGateway.get_payment_gateways') }}',
                columns: [
                    // { data: 'logo', name: 'tour_operators.logo', orderable: false, searchable: false,visible:false },
                    {
                        // "data": ["image","file"],


                        "render": function (data,type,row) {
                            return`
    ${'<img src="'+row.payment_gateway_image+'" class="avatar" width="60" height="60" style="border-radius:50%"/>'}
            `
                        },
                    },
                    { data: 'payment_gateway_name', name: 'payment_gateway_name', orderable: true, searchable: true},
                    { data : "activate_gateway", "className": "text-center",
                        render: function(data, type, row, meta){
                            return  `
                           <div class="btn-group flex-wrap pull-right">

                            ${(row.status == 1) ?
                                `   <label class="switch">
                                <input type="checkbox" id="activate_gateway" checked>
                            <span class="slider round"></span>
                            </label>` :
                                `   <label class="switch">
                                <input type="checkbox" id="activate_gateway">
                            <span class="slider round"></span>
                            </label>`}
&nbsp; &nbsp;
        </div>`
                        }
                    },
                    { data: 'gateway_status', name: 'gateway_status', orderable: true, searchable: true},
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
            $(document).on('click','#activate_gateway',function(){
                var data = table.row( $(this).parents('tr') ).data();
                var status  = data.status
                var id = data.id
                $.ajax({
                    type: "GET",
                    dataType: "JSON",
                    url: '{{route('paymentGateway.activateGateway')}}',
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
