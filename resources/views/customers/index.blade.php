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
#myTable .p_status {
    display: block;
    width: 95px;
    text-align: center;
    color: #fff;
    border-radius: 10px;
}
#myTable .p_status {
    display: block;
    width: 95px;
    text-align: center;
    color: #fff;
    border-radius: 10px;
    height: 28px;
    line-height: 25px;
}
</style>

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('orders.dash_index')}}"> Orders </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Customers</a></li>
                </ul>
            </div>
             <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <h5>Customers</h5>
                                    <div>
                                        <a  href="{{ route('customers.add') }}" class="add-article-btn">Add Customer</a>
                                        <a id="download_customer_list" style="cursor: pointer;" class="add-article-btn">Download Customer List</a>
                                    </div>
                                </div>
                                <div class="card-body card-block px-0 py-3">
                                    <form id="search_daily_status" data-parsley-validate>
                                    @csrf
                                    <div class="mb-3 filter-sec">
                                        <div class="row input_group">

                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                <label>Search <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please search Customers by Name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                <input type="text" id="search_text" name="search_text" class="form-control" placeholder="Search" data-parsley-required-message="Please Enter Text" data-parsley-errors-container="#error_message" >
                                                <span id="error_message" class="error-container"></span>
                                            </div>
                                            
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <label>Date <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Date Range" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
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
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                <label>Product Status <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Product Status To See Customers List" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                <select class="form-control select2" id="pro_status_select" name="pro_status[]" multiple data-parsley-required-message="Please Select Status" data-parsley-errors-container="#error_message">
                                                    <option value="Order">Order</option>
                                                    <option value="Cart">Cart</option>
                                                    <option value="Wish List">Wish List</option>
                                                </select>
                                                <span id="error_message" class="error-container"></span>
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
                                                <th scope="col"><input type="checkbox" class="pinned_chekbox" id="all_customers_list" val="" name="" data-id=''></th>
                                                <th scope="col">Sr.No.</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Mobile number</th>
                                                <th scope="col">Mail Id</th>
                                                <th scope="col">Product Status</th>
                                                <th scope="col">Approval</th>
                                                <th scope="col">Product Access</th>
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
<div class="modal" tabindex="-1" id="access_modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Product Access</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body add-article">
            <div class="input_group">
                <input type="hidden" name="access_user_id" id="access_user_id" value="">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input modal_access_radio" type="radio" name="access_check" id="inlineRadio1" value="limited_access">
                        <label class="form-check-label" for="inlineRadio1" style="cursor: pointer;">Limited Access</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input modal_access_radio" type="radio" name="access_check" id="inlineRadio2" value="unlimited_access">
                        <label class="form-check-label" for="inlineRadio2" style="cursor: pointer;">Unlimited Access</label>
                    </div>
                </div>
                <div id="date_time_section">
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                        <label>Start Date </label>
                        <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <input type="text" name="start_date" class="form-control me-2" placeholder="Start Date" readonly id="start_date">
                            <span id="product_access_start_date_error" style="color: red;"></span>
                            </div> 
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <input class="form-control" id="start_time" name="start_time" type="time" value="" placeholder="Start Time">
                                <span id="product_access_start_time_error" style="color: red;"></span>
                            </div> 
                        </div>
                    </div>
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                        <label>End Date </label>
                        <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <input type="text" name="end_date" placeholder="End Date" class="form-control" id="end_date" readonly >
                                <span id="product_access_end_date_error" style="color: red;"></span>
                            </div> 
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <input class="form-control" id="end_time" name="end_time" type="time" value="" placeholder="End Time">
                                <span id="product_access_end_time_error" style="color: red;"></span>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="save_access_btn">Save</button>
        </div>
      </div>
    </div>
  </div>      
  
  <div class="modal" tabindex="-1" id="site_access_modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Site Access</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body add-article">
            <div class="input_group">
                <input type="hidden" name="access_user_id" id="site_access_user_id" value="">
                <p id="warning_text" style="color: red;"></p>
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                    <div class="form-check form-check-inline" id="s_l_radio">
                        <input class="form-check-input site_access_radio" type="radio" name="s_access_check" id="inlineRadio3" value="limited_access">
                        <label class="form-check-label" for="inlineRadio3" style="cursor: pointer;">Limited Access</label>
                    </div>
                    <div class="form-check form-check-inline" id="s_u_radio">
                        <input class="form-check-input site_access_radio" type="radio" name="s_access_check" id="inlineRadio4" value="unlimited_access">
                        <label class="form-check-label" for="inlineRadio4" style="cursor: pointer;">Unlimited Access</label>
                    </div>
                </div>
                <div id="site_date_time_section">
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                        <label>Start Date </label>
                        <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <input type="text" name="site_start_date" class="form-control me-2" placeholder="Start Date" readonly id="site_start_date">
                            <span id="site_access_start_date_error" style="color: red;"></span>
                            </div> 
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <input class="form-control" id="site_start_time" name="site_start_time" type="time" value="" placeholder="Start Time">
                                <span id="site_access_start_time_error" style="color: red;"></span>
                            </div> 
                        </div>
                    </div>
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                        <label>End Date </label>
                        <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <input type="text" name="site_end_date" placeholder="End Date" class="form-control" id="site_end_date" readonly >
                                <span id="site_access_end_date_error" style="color: red;"></span>
                            </div> 
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <input class="form-control" id="site_end_time" name="site_end_time" type="time" value="" placeholder="End Time">
                                <span id="site_access_end_time_error" style="color: red;"></span>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="site_save_access_btn">Save</button>
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
        autoWidth: false,
        responsive:true,
        serverSide: true,
        columnDefs: [
        {
            targets: [0, 8],
            orderable: false,
        },
        { width: "1%", targets: 0 },
        { width: "5%", targets: 1 },
        { width: "15%", targets: 2 },
        { width: "10%", targets: 3 },
        { width: "10%", targets: 4 },
        { width: "20%", targets: 5 },
        { width: "14%", targets: 6 },
        { width: "15%", targets: 7 },
        { width: "10%", targets: 8 },


        ],
        ajax: {
            url: admin_url + "customers/list",
            type: 'post',
            data: function(d) {
                d._token = token;
                d.search_text = $('#search_text').val();
                d.from_date = $('#from_date').val();
                d.pro_status = $('#pro_status_select').val();
            }
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
            data: 'name',
            name: 'name',
            orderable: true,
            searchable: true

        },
        {
            data: 'mo_num',
            name: 'mo_num',
        },
        {
            data: 'email',
            name: 'email',
        },
        {
            data: 'pro_status',
            name: 'pro_status',
        },
        {
            data: 'a_status',
            name: 'a_status',
        },
        {
            data: 'access_status',
            name: 'access_status',
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
        if ($('#search_text').val() != '' || $('#from_date').val() != '' || $('#to_date').val() != '' || $('#pro_status_select').val() != '') {
            table.ajax.reload(); 
        } else {
            toastr.error('Please choose one input field')
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

    $(document).on('click', '#is_status', function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        var isChecked = $(this).is(':checked');
        $.ajax({
            url: admin_url + "customers/is_status",
            type: "post",
            data: {
                _token: token,
                isChecked: isChecked,
                id: id,
            },
            success: function(data) {
                if (data.status == 1) {
                    toastr.success(data.message);
                }else{
                    toastr.error(data.message);
                }

            }
        });
    })
    $(document).on('click','#download_customer_list', function(e){
        var all_customers_list = $('#all_customers_list:checkbox:checked').val();
        var selectedValues = [];
        $('.pinned_chekbox:checkbox:checked').each(function(){
            selectedValues.push($(this).attr('data-id'));
        });
        $.ajax({
            type: "POST",
            url: '{{ route("customer.export") }}',
            data: {
                _token: "{{ csrf_token() }}",
                selectedValues:selectedValues,
                all_customers_list:all_customers_list,
            },
            success: function(response) {
                const data = JSON.parse(response);
                if(data != 'blank'){
                $("#dvjson").excelexportjs({
                    containerid: "dvjson", 
                    datatype: 'json',
                    worksheetName:'Customers list',
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

    $(document).on('click','#all_customers_list', function(e){
        $('.pinned_chekbox:checkbox').not(this).prop('checked', this.checked);
    });
    $(document).on('click', '.chage_user_status', function() {
        var user_id = $(this).data('id');
        var type = $(this).data('type');
        var access = '{{ $limited_access }}';
        if(access == 1 && type == 'approve')
        {
            $('#site_access_user_id').val(user_id);
            $('#site_start_date').val('');
            $('#site_start_time').val('');
            $('#site_end_date').val('');
            $('#site_end_time').val('');
            if(access == 1)
            {
                $('#site_date_time_section').show();
                $('#inlineRadio3').prop('checked',true); 
                $('#s_u_radio').hide();
                var text = 'Currently Limited Access is default set';
                $("#site_start_date").datepicker({ 
                autoclose: true, 
                todayHighlight: true
                }).on('changeDate', function(selected) {
                var startDate = new Date(selected.date.valueOf());
                $('#site_end_date').datepicker('setStartDate', startDate);
                });

                $("#site_end_date").datepicker({ 
                autoclose: true, 
                todayHighlight: true
                });
                $('#site_start_date').prop('required',true);
                $('#site_start_time').prop('required',true);
                $('#site_end_date').prop('required',true);
                $('#site_end_time').prop('required',true);
            }else{
                $('#site_date_time_section').hide();
                $('#inlineRadio4').prop('checked',true);
                $('#s_l_radio').hide(); 
                var text = 'Currently UnLimited Access is default set';
                $('#site_start_date').prop('required',false);
                $('#site_start_time').prop('required',false);
                $('#site_end_date').prop('required',false);
                $('#site_end_time').prop('required',false);
            }
            $('#warning_text').text(text);
            $('#site_access_modal').modal('show');
        }else{
            var label = '';
            if(type == 'approve')
            {
                var approval = 1; 
                var label = 'Approve';
            }else{
                var approval = 2;
                var label = 'Reject';
            }
            
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to '+ label +' User!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, '+ label +' it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route("customer.approval.status") }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            user_id:user_id,
                            approval:approval,
                        },
                        success: function(response) {
                            if(response.status == 1)
                            {
                                toastr.success(response.message);
                                table.ajax.reload();  
                            }else{
                                toastr.error(response.message);
                            }
                        }
                    });
                }
            }); 
        }
    });
    $(document).on('click', '.edit_access', function() {
        var user_id = $(this).data('id');
        var type = $(this).data('type');
        var access_control = '{{ $limited_access }}';
        $('#site_access_start_date_error').text('');
        $('#site_access_end_date_error').text('');
        $('#site_access_start_time_error').text('');
        $('#site_access_end_time_error').text('');
        $('#product_access_start_date_error').text('');
        $('#product_access_end_date_error').text('');
        $('#product_access_start_time_error').text('');
        $('#product_access_end_time_error').text('');

        $.ajax({
            type: "POST",
            url: '{{ route("customer.check.access") }}',
            data: {
                _token: "{{ csrf_token() }}",
                user_id:user_id,
            },
            success: function(response) {
                if(response.status == 1)
                {
                    if(type == 'product_access')
                    {
                        $('#access_user_id').val(response.user.id);
                        $('#start_date').val(response.user.start_date);
                        $('#start_time').val(response.user.start_time);
                        $('#start_time').val(response.user.start_time);
                        $('#end_date').val(response.user.end_date);
                        $('#end_time').val(response.user.end_time);
                        if(response.user.product_access == 1)
                        {
                            $('#date_time_section').show();
                            $('#inlineRadio1').prop('checked',true); 
                            $("#start_date").datepicker({ 
                                autoclose: true, 
                                todayHighlight: true
                            }).on('changeDate', function(selected) {
                                var startDate = new Date(selected.date.valueOf());
                                $('#end_date').datepicker('setStartDate', startDate);
                                if ($('#end_date').datepicker('getDate') < startDate) {
                                    $('#end_date').val('');
                                }
                            });
                            $("#end_date").datepicker({ 
                                autoclose: true, 
                                todayHighlight: true
                            });
                            var startDateFromResponse = $('#start_date').val();
                            if (startDateFromResponse) {
                                var startDate = new Date(startDateFromResponse);
                                $('#end_date').datepicker('setStartDate', startDate);
                            }
                        }else{
                            $('#date_time_section').hide();
                            $('#inlineRadio2').prop('checked',true);
                        }
                        $('#access_modal').modal('show'); 
                    }else if(type == 'site_access')
                    {
                        $('#site_access_user_id').val(response.user.id);
                        $('#site_start_date').val(response.user.site_access_start_date);
                        $('#site_start_time').val(response.user.site_access_start_time);
                        $('#site_end_date').val(response.user.site_access_end_date);
                        $('#site_end_time').val(response.user.site_access_end_time);
                        $('#s_l_radio').show();
                        $('#s_u_radio').show();
                        $("#site_start_date").datepicker({ 
                            autoclose: true, 
                            todayHighlight: true
                        }).on('changeDate', function(selected) {
                            var startDate = new Date(selected.date.valueOf());
                            $('#site_end_date').datepicker('setStartDate', startDate);
                            if ($('#site_end_date').datepicker('getDate') < startDate) {
                                $('#site_end_date').val('');
                            }
                        });
                        $("#site_end_date").datepicker({ 
                            autoclose: true, 
                            todayHighlight: true
                        });
                        var startDateFromResponse = $('#site_start_date').val();
                        if (startDateFromResponse) {
                            var startDate = new Date(startDateFromResponse);
                            $('#site_end_date').datepicker('setStartDate', startDate);
                        }
                        if(response.user.site_access == 1)
                        {
                            $('#site_date_time_section').show();
                            $('#inlineRadio3').prop('checked',true); 
                            $('#site_start_date').prop('required',true);
                            $('#site_start_time').prop('required',true);
                            $('#site_end_date').prop('required',true);
                            $('#site_end_time').prop('required',true);
                        }else{
                            $('#site_date_time_section').hide();
                            $('#site_start_date').prop('required',false);
                            $('#site_start_time').prop('required',false);
                            $('#site_end_date').prop('required',false);
                            $('#site_end_time').prop('required',false);
                            $('#inlineRadio4').prop('checked',true);
                        }
                        if(access_control == 1)
                        {
                            var text = 'Currently Limited Access is default set';
                        }else{
                            var text = 'Currently UnLimited Access is default set';
                        }
                        $('#warning_text').text(text);
                        $('#site_access_modal').modal('show'); 
                    }
                    
                }else{
                    toastr.error(response.message);
                }
            }
        });
    });

    $(document).on('click', '#save_access_btn', function() {
        var flag = 0;
        var check_start_date = $('#start_date');
        var check_end_date = $('#end_date');
        var check_start_time = $('#start_time');
        var check_end_time = $('#end_time');
        if (check_start_date.is('[required]') && !check_start_date.val()) {
            flag++
            $('#product_access_start_date_error').text('Start Date is required');
        }else{
            $('#product_access_start_date_error').text('');
        }
        if (check_end_date.is('[required]') && !check_end_date.val()) {
            flag++
            $('#product_access_end_date_error').text('End Date is required');
        }else{
            $('#product_access_end_date_error').text('');
        }
        if (check_start_time.is('[required]') && !check_start_time.val()) {
            flag++
            $('#product_access_start_time_error').text('Start Time is required');
        }else{
            $('#product_access_start_time_error').text('');
        }
        if (check_end_time.is('[required]') && !check_end_time.val()) {
            flag++
            $('#product_access_end_time_error').text('End Time is required');
        }else{
            $('#product_access_end_time_error').text('');
        }
        
        var user_id = $('#access_user_id').val();
        var access_type = $("input[name='access_check']:checked").val();
        var start_date = $('#start_date').val();
        var start_time = $('#start_time').val();
        var end_date = $('#end_date').val();
        var end_time = $('#end_time').val();
        if(flag == 0)
        {
            $('#access_modal').modal('hide');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to Change User Access!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Change it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route("customer.update.access") }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            user_id: user_id,
                            access_type: access_type,
                            start_date: start_date,
                            start_time: start_time,
                            end_date: end_date,
                            end_time: end_time,
                        },
                        success: function(response) {
                            if(response.status == 1)
                            {
                                toastr.success(response.message);
                                table.ajax.reload();  
                            }else{
                                toastr.error(response.message);
                            }
                        }
                    });
                }
            });
        }
    });
    $(document).on('change', '.modal_access_radio', function() {
        var access_type = $("input[name='access_check']:checked").val();
        if(access_type == 'limited_access')
        {
            $('#date_time_section').show();
            $('#start_date').prop('required',true);
            $('#start_time').prop('required',true);
            $('#end_date').prop('required',true);
            $('#end_time').prop('required',true);
        }else{
            $('#date_time_section').hide();
            $('#start_date').prop('required',false);
            $('#start_time').prop('required',false);
            $('#end_date').prop('required',false);
            $('#end_time').prop('required',false);
            $('#product_access_start_date_error').text('');
            $('#product_access_end_date_error').text('');
            $('#product_access_start_time_error').text('');
            $('#product_access_end_time_error').text('');
        }
    });
    $(document).on('change', '.site_access_radio', function() {
        var access_type = $("input[name='s_access_check']:checked").val();
        if(access_type == 'limited_access')
        {
            $('#site_date_time_section').show();
            $('#site_start_date').prop('required',true);
            $('#site_start_time').prop('required',true);
            $('#site_end_date').prop('required',true);
            $('#site_end_time').prop('required',true);
        }else{
            $('#site_date_time_section').hide();
            $('#site_start_date').prop('required',false);
            $('#site_start_time').prop('required',false);
            $('#site_end_date').prop('required',false);
            $('#site_end_time').prop('required',false);
            $('#site_access_start_date_error').text('');
            $('#site_access_end_date_error').text('');
            $('#site_access_start_time_error').text('');
            $('#site_access_end_time_error').text('');
        }
    });
    $(document).on('click', '#site_save_access_btn', function() {
        var flag = 0;
        var start_date = $('#site_start_date');
        var end_date = $('#site_end_date');
        var start_time = $('#site_start_time');
        var end_time = $('#site_end_time');
        if (start_date.is('[required]') && !start_date.val()) {
            flag++
            $('#site_access_start_date_error').text('Start Date is required');
        }else{
            $('#site_access_start_date_error').text('');
        }
        if (end_date.is('[required]') && !end_date.val()) {
            flag++
            $('#site_access_end_date_error').text('End Date is required');
        }else{
            $('#site_access_end_date_error').text('');
        }
        if (start_time.is('[required]') && !start_time.val()) {
            flag++
            $('#site_access_start_time_error').text('Start Time is required');
        }else{
            $('#site_access_start_time_error').text('');
        }
        if (end_time.is('[required]') && !end_time.val()) {
            flag++
            $('#site_access_end_time_error').text('End Time is required');
        }else{
            $('#site_access_end_time_error').text('');
        }
        var user_id = $('#site_access_user_id').val();
        var start_date = $('#site_start_date').val();
        var start_time = $('#site_start_time').val();
        var end_date = $('#site_end_date').val();
        var end_time = $('#site_end_time').val();
        var s_access_type = $("input[name='s_access_check']:checked").val();
        if(flag == 0)
        {
            $('#site_access_modal').modal('hide');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to Approve User!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Approve it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route("customer.approval.status") }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            user_id: user_id,
                            start_date: start_date,
                            start_time: start_time,
                            end_date: end_date,
                            end_time: end_time,
                            approval: 1,
                            limited_access: 1,
                            s_access_type: s_access_type,
                        },
                        success: function(response) {
                            if(response.status == 1)
                            {
                                toastr.success(response.message);
                                table.ajax.reload();  
                            }else{
                                toastr.error(response.message);
                            }
                        }
                    });
                }
            }); 
        }
    });
});
 </script>
 @endsection