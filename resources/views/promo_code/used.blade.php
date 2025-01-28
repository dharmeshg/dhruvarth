@extends('layouts.backend.index')
@section('main_content')
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <h5>{{ isset($promo_code->code) ? $promo_code->code : '' }}</h5>
                                </div>
                                <div class="card-block px-0 py-3">
                                        <div class="mb-3 filter-sec">
                                            <div class="row input_group">
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label>Search <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please search from here for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="search_text" class="form-control" placeholder="Search" id="search_text">
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                    <label>Date <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Date For Promocode" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <div class="row">
                                                       <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 5px;">
                                                        <input type="text" name="from_date" class="form-control me-2" placeholder="From Date" readonly id="from_date"  >
                                                       </div> 
                                                       <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                        <input type="text" name="to_date" placeholder="To Date" class="form-control" id="to_date" readonly>
                                                       </div> 
                                                    </div>
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 btn-sec" style="margin-top: 28px;">
                                                    <button class="btn table-filter-btn" type="button" id="seach_filter">Filter</button>
                                                    <a class="btn" style="color: #DE5757; display: none;" id="clear_filter">X Clear Filter</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none" id="invalid_message_div">
                                            <p style="color: #DE5757;" id="error_p_tag"></p>
                                        </div>
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">#</th>
                                                    <th scope="col">User Name</th>
                                                    <th scope="col">User Email</th>
                                                    <th scope="col">Used Date</th>
                                                    <th scope="col">Order Amount</th>
                                                    <th scope="col">Discounted Price</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
 <script>
$(document).ready(function() {
    $("#from_date").datepicker({ 
    autoclose: true, 
    todayHighlight: true
    }).on('changeDate', function(selected) {
    var startDate = new Date(selected.date.valueOf());
    $('#to_date').datepicker('setStartDate', startDate);
    });

    $("#to_date").datepicker({ 
    autoclose: true, 
    todayHighlight: true
    });
});
    $(document).ready(function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var table = $('#myTable').DataTable({
            language: {
                "searchPlaceholder": "Search",
                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>',
                paginate: {
                    next: 'Next',
                    previous: 'Previous'
                }
            },
            processing: true,
            autoWidth: false,
            serverSide: true,
            searching: false,
            responsive: true,
            columnDefs: [
                { targets: [0, 6], orderable: false },
                { width: "5%", targets: 0 },
                { width: "15%", targets: 1 },
                { width: "20%", targets: 2 },
                { width: "20%", targets: 3 },
                { width: "15%", targets: 4 },
                { width: "15%", targets: 5 },
                { width: "00%", targets: 6 },
            ],
            ajax: {
                url: admin_url + "promo-code-used/list",
                type: 'post',
                data: function(d) {
                    d._token = token;
                    d.search_text = $('#search_text').val();
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();    
                    d.promo_id = '{{ $promo_code->id }}';
                }
            },
            columns: [
                { data: 'ser_id', name: 'id', orderable: false, searchable: false },
                { data: 'user_name', name: 'user_name', orderable: false, searchable: false },
                { data: 'user_email', name: 'user_email', orderable: false, searchable: false },
                { data: 'used_date', name: 'used_date', orderable: false, searchable: false },
                { data: 'order_price', name: 'order_price', orderable: false, searchable: false },
                { data: 'order_discount', name: 'order_discount', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            pagingType: 'simple_numbers'
        });
    
        $("#seach_filter").click(function(){
            $('#clear_filter').css('display','');
            if ($('#search_text').val() != '2' || $('#discount_type').val() != '' || $('#public_select').val() != '') {
                table.ajax.reload();
            } else {
                toastr.error('Please choose one input field');
            }
        });
        $(document).on("click", "#clear_filter", function() {
            $("#search_text").val("");
            $("#from_date").val("");
            $('#to_date').val('');
            $('#discount_type').val('2');
            $('#status').val('2');
            $('#public_select').val('2');
            table.ajax.reload();
            $('#clear_filter').css('display','none');

        });
    });
</script>
@endsection