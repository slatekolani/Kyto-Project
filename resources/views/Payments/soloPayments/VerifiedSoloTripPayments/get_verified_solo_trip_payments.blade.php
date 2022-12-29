<table class="table table-hover table-responsive-md" id="Verified-solo-Trip-Payments">
    <thead>
    <tr>
        <th>@lang('Tourist name')</th>
        <th>@lang('Phone number')</th>
        <th>@lang('Email address')</th>
        <th>@lang('Date of booking')</th>
        <th>@lang('Account name')</th>
        <th>@lang('Amount')</th>
        <th>@lang('Reference #')</th>
        <th>@lang('Payment gateway')</th>
        <th>@lang('Confirm payment')</th>
        <th>@lang('Payment status')</th>
        <th>@lang('action')</th>
    </tr>
    </thead>
</table>

@push('after-scripts')

    <script  type="text/javascript">

        $(function() {
            var url = "{{ url("/") }}";
            var table= $('#Verified-solo-Trip-Payments').DataTable({
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

                ajax: '{{ route('soloBookingPayments.getVerifiedSoloTripPayments',$tour_operator->uuid) }}',
                columns: [
                    { data: 'tourist_name', name: 'tourist_name', orderable: true, searchable: true},
                    { data: 'phone_number', name: 'phone_number', orderable: true, searchable: true},
                    { data: 'email_address', name: 'email_address', orderable: true, searchable: true},
                    { data: 'date_of_booking', name: 'date_of_booking', orderable: true, searchable: true},
                    { data: 'account_name', name: 'account_name', orderable: true, searchable: true},
                    { data: 'amount', name: 'amount', orderable: true, searchable: true},
                    { data: 'reference', name: 'reference', orderable: true, searchable: true},
                    { data: 'payment_gateway', name: 'payment_gateway', orderable: true, searchable: true},
                    { data : "verify_payment", "className": "text-center",
                        render: function(data, type, row, meta){
                            return  `
                           <div class="btn-group flex-wrap pull-right">

                            ${(row.status == 1) ?
                                `   <label class="switch">
                                <input type="checkbox" id="change_payment_status" checked>
                            <span class="slider round"></span>
                            </label>` :
                                `   <label class="switch">
                                <input type="checkbox" id="change_payment_status">
                            <span class="slider round"></span>
                            </label>`}
&nbsp; &nbsp;
        </div>`
                        }
                    },
                    { data: 'payment_status', name: 'payment_status', orderable: false, searchable: false},
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                //nation must be included, payment gateway used
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
            $(document).on('click','#change_payment_status',function(){
                var data = table.row( $(this).parents('tr') ).data();
                var status  = data.status
                var id = data.id
                $.ajax({
                    type: "GET",
                    dataType: "JSON",
                    url: '{{route('soloBookingPayments.changePaymentStatus')}}',
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
