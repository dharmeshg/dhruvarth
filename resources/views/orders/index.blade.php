@extends('layouts.backend.index')
@section('main_content')
<style>
    .datepicker-days{display: block !important;}
    .customer_product{cursor: pointer;}

    .select2-container .select2-selection--multiple{
        color: #000 !important;
        border-radius: unset !important;
        background: #FFFFFF !important;
        padding: 5px !important;
        border: 1px solid #CED4DA !important;
    }
    
</style>


<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('orders.dash_index')}}"> Orders </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Orders</a></li>
                </ul>
            </div>

            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <h5>Orders</h5>
                                    <a id="download_orders_list" style="cursor: pointer;" class="add-article-btn">Download Orders List</a>
                                </div>
                                <div class="card-body card-block px-0 py-3">
                                    <!-- <div class="example"> -->

                                        <!-- <div class="tab-content rounded-bottom"> -->
                                            <form id="search_daily_status" data-parsley-validate>
                                                @csrf
                                                <div class="mb-3 filter-sec">
                                                    <div class="row input_group">

                                                       <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label>Status <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Visibility Status" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                        <select class="form-control" id="pro_status_select" name="pro_status" data-parsley-required-message="Please Select Status" data-parsley-errors-container="#error_message">
                                                            <option selected="" disabled="">Please Select Status</option>
                                                            <option value="Pending">Pending</option>
                                                            <option value="Processing">Processing</option>
                                                            <option value="On Delivery">In Transit</option>
                                                            <option value="Completed">Completed</option>
                                                            <option value="Declined">Declined</option>

                                                        </select>
                                                        <span id="error_message" class="error-container"></span>
                                                    </div>
                                                    
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Date <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Date Range" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                        <div class="row">
                                                         <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                            <input type="text" name="from_date" class="form-control me-2" placeholder="From Date" readonly id="from_date"  data-parsley-required-message="Select From Date" data-parsley-errors-container="#error_message2" >
                                                            <span id="error_message2"></span>
                                                        </div> 
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                            <input type="text" name="to_date" placeholder="To Date" class="form-control" id="to_date" readonly  data-parsley-required-message="Select To Date" data-parsley-errors-container="#error_message3">
                                                            <span id="error_message3"></span>
                                                        </div> 
                                                    </div>
                                                </div>

                                                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2 btn-sec">
                                                    <button class="btn table-filter-btn" type="button" id="seach_filter">Filter</button>
                                                    <a class="btn" style="color: #DE5757; display: none;" id="clear_filter">X Clear Filter</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col"><input type="checkbox" class="pinned_chekbox" id="all_orders_list" val="" name="" data-id=''></th>
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Customer Email</th>
                                                    <th scope="col">Order No.</th>
                                                    <th scope="col">Total Qty</th>
                                                    <th scope="col">Total Cost</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Order Status</th>
                                                    <th scope="col">Payment Status</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- </div> -->
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                        

<div class="modal" tabindex="-1" id="section_add_modal">
  <div class="modal-dialog">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">        
                <input type="hidden" id="order_id" name="order_id">
                <div class="input_group">
                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlTextarea1">Payment Status <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Payment Status"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                        <select class="form-control" id="payment_status" name="payment_status">
                            <option value="Paid">Paid</option>
                            <option value="UnPaid">UnPaid</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlTextarea1">Order Status <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Payment Status"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                        <select class="form-control" id="order_status" name="order_status">
                            <option value="Pending">Pending</option>
                            <option value="Processing">Processing</option>
                            <option value="On Delivery">On Delivery</option>
                            <option value="Completed">Completed</option>
                            <option value="Declined">Declined</option>
                        </select>
                    </div>

                    <div class="mb-3" id="link_bc" style="display: none;">
                        <label class="form-label" >Tracking Url <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Enter Link"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                        <input type="text" name="link" id="link" class="form-control">
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_sec">Save</button>
            </div>
    </div>
</div>
</div>       
@endsection
@section('script')

<script src="{{ asset('assets/js/excelexportjs.js')}}"></script>

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
    $('#search_daily_status').parsley();
    var token = $("meta[name='csrf-token']").attr("content");

    var table = $('#myTable').DataTable({
        language: {
            "searchPlaceholder": "Search",
            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>',
            paginate: {
                        next: 'Next', // 'Next' label for the next button
                        previous: 'Previous'
                    }
                },
                processing: true,
                responsive: true,
                autoWidth: false,
                columnDefs: [
                {
                    targets: [0, 9],
                    orderable: false,
                },
                { width: "5%", targets: 0 },
                { width: "5%", targets: 1 },
                { width: "20%", targets: 2 },
                { width: "10%", targets: 3 },
                { width: "15%", targets: 4 },
                { width: "15%", targets: 5 },
                { width: "10%", targets: 6 },
                { width: "10%", targets: 7 },
                { width: "10%", targets: 8 },




                ],
                ajax: {
                    url: admin_url + "orders/list",
                    type: 'post',
                    data: {
                        _token: token,
                    },
                },
                columns: [{
                    data: 'ser_id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'ser_id_num',
                    name: 'ser_id_num',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'customers_mail',
                    name: 'customers_mail',
                    orderable: true,
                    searchable: true

                },
                {
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'total_qty',
                    name: 'total_qty',
                },
                {
                    data: 'total',
                    name: 'total',
                },
                {
                    data: 'date',
                    name: 'date',
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'p_status',
                    name: 'p_status',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'Action',
                }
                ],
                pagingType: 'simple_numbers',
                // dom: 'frtip',
                searching: false,
            });

    $("#seach_filter").click(function(){
        $('#clear_filter').css('display','');


        // $('#search_daily_status').parsley().validate();
        if ($('#from_date').val() != '' || $('#to_date').val() != '' || $('#pro_status_select').val() != null) {

            var formData = $('#search_daily_status').serialize();
            $.ajax({
                url: '{{route('orders.search')}}', 
                type: 'POST',
                data: formData,
                success: function (response) {
                // Handle success response from the server
                console.log(response);
                var newData = response.data;
                table.clear().rows.add(newData).draw();
            },
            error: function (error) {
                // Handle error response from the server
                console.error(error);
            }
        });
        } else {
            toastr.error('Please choose one input field');
        }

    });

    $(document).on("click", "#clear_filter", function() {
        $("#search_text").val("");
        $("#from_date").val("");
        $("#to_date").val("");
        $("#pro_status_select").val("").trigger("change");


        table.ajax.reload();
        $('#clear_filter').css('display','none');
    });




    $(document).on('click','#download_orders_list', function(e){

        var all_orders_list = $('#all_orders_list:checkbox:checked').val();
        var selectedValues = [];
        $('.pinned_chekbox:checkbox:checked').each(function(){
            selectedValues.push($(this).attr('data-id'));
        });

        $.ajax({
            type: "POST",
            url: '{{ route("orders.export") }}',
            data: {
                _token: "{{ csrf_token() }}",
                selectedValues:selectedValues,
                all_orders_list:all_orders_list,
            },
            success: function(response) {
                const data = JSON.parse(response);
                if(data != 'blank'){
                    $("#dvjson").excelexportjs({
                      containerid: "dvjson", 
                      datatype: 'json',
                      worksheetName:'Orders list',
                      dataset: data, 
                      columns: getColumns(data)     
                  });
                }else {
                    Swal.fire({
                        text: 'No Data Found!',
                        icon: 'warning',
                    });
                }

            }
        });


    });

    $(document).on('click','#all_orders_list', function(e){
        $('.pinned_chekbox:checkbox').not(this).prop('checked', this.checked);
    });

     $(document).on('change','#order_status', function(e){
        var o_status = $('#order_status').val();
        if(o_status == 'On Delivery'){
            $("#link_bc").show();
        }else{
            $("#link_bc").hide();
        }
    });


    $(document).on('click','.edit', function(e){
        var id = $(this).data('id');
        // var formData = $('#orders.get.status').serialize();
            $.ajax({
                url: '{{route('orders.get.status')}}', 
                type: 'POST',
                data: {
                    id:id,
                    _token: "{{ csrf_token() }}",
                },
                success: function (response) {
                if(response.status == 1)
                {
                    console.log(response.data);
                    $('#order_id').val(response.data.id);
                    $('#payment_status').val(response.data.payment_status);
                    $('#order_status').val(response.data.status);
                    if(response.data.status == 'On Delivery'){
                        $('#link').val(response.data.link);
                        $("#link_bc").show();
                    }
                    $('#section_add_modal').modal('show');
                }
            },
            error: function (error) {
                // Handle error response from the server
                console.error(error);
            }
        });
    });

    $(document).on('click','#save_sec', function(e){
        var id = $('#order_id').val();
        var p_status = $('#payment_status').val();
        var o_status = $('#order_status').val();
        var link = $('#link').val();
 
        $.ajax({
                url: '{{route('orders.change.status')}}', 
                type: 'POST',
                data: {
                    id:id,
                    p_status:p_status,
                    o_status:o_status,
                    link:link,
                    _token: "{{ csrf_token() }}",
                },
                success: function (response) {
                if(response.status == 1)
                {
                    table.ajax.reload();
                    $('#section_add_modal').modal('hide');
                    toastr.success(response.message);
                }else{
                    toastr.error('Something Went Wrong!');
                }
            },
            error: function (error) {
                toastr.error('Something Went Wrong!');
            }
        });
    });


});
</script>
@endsection