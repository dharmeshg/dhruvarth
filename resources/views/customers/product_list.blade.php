@extends('layouts.backend.index')
@section('main_content')
<style>
    .datepicker-days{display: block !important;}
.customer_product{cursor: pointer;}
    
</style>

                      <div class="pcoded-wrapper">
                        <div class="pcoded-content">
                            <div class="pcoded-inner-content">
                                <div class="main-body">
                                    <div class="page-wrapper">
                                        <div class="row">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="card Recent-Users mb-4">
                                                    <div class="card-header">
                                                        <h5>{{$users->name}} / @if($pro_status == 'orders') Order List @elseif($pro_status == 'cart') Cart List @elseif($pro_status == 'wish-list') Wish List @endif</h5>
                                                        <a href="{{route('customers.index')}}" class="add-article-btn">Back to Customer List</a>
                                                    </div>
                                                    <div class="card-body card-block px-0 py-3">
                                                        <!-- <div class="example"> -->

                                                            <!-- <div class="tab-content rounded-bottom"> -->
                                            <form id="search_daily_status" data-parsley-validate>
                                            @csrf
                                            <input type="hidden" name="product_status" value="{{isset($pro_status) ? $pro_status : ''}}">
                                            <input type="hidden" name="customer_id" value="{{isset($users->id) ? $users->id : ''}}">

                                            <div class="mb-3 filter-sec">
                                                <div class="row input_group">

                                                     <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label>Search</label>
                                                        <input type="text" id="search_text" name="search_text" class="form-control" placeholder="Search" data-parsley-required-message="Please Enter Text" data-parsley-errors-container="#error_message" >
                                                        <span id="error_message" class="error-container"></span>
                                                    </div>
                                                    
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <label>Date</label>
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
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-sec">
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
                                                                                <th scope="col">No.</th>
                                                                                <th scope="col">Product Image</th>
                                                                                <th scope="col">Product name</th>
                                                                                <th scope="col">Product SKU</th>
                                                                                <th scope="col">Register Date & Time</th>
                                                                                @if($_GET['status'] == 'cart')
                                                                                <th scope="col">Comment</th>
                                                                                @endif
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
<div class="modal fade" id="show_comment_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCenterTitle">View Comment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div><p id="comment_display" style="text-align: justify;"></p></div>
            <div><p id="name_display" style="text-align: right;font-size: 20px;font-weight: 800;color: #000;"></p></div>
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
          var product_status = <?php echo json_encode($pro_status); ?>;
          var customer_id = <?php echo json_encode($users->id); ?>;

          @if($_GET['status'] == 'cart')
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
            columnDefs: [
            {
                targets: [0, 5],
                orderable: false,
            },
            { width: "1%", targets: 0 },
            { width: "24%", targets: 1 },
            { width: "25%", targets: 2 },
            { width: "25%", targets: 3 },
            { width: "20%", targets: 4 },
            { width: "5%", targets: 4 },
            ],
            ajax: {
                url: admin_url + "customers/product_details_list",
                type: 'post',
                data: {
                    _token: token,
                    product_status:product_status,
                    customer_id:customer_id,

                },
            },
            columns: [
            {
                data: 'ser_id_num',
                name: 'ser_id_num',
                orderable: false,
                searchable: false
            },
            {
                data: 'pro_image',
                name: 'pro_image',
                orderable: false,
                searchable: false

            },
            {
                data: 'pro_name',
                name: 'pro_name',
                orderable: false,
                searchable: false
            },
            {
                data: 'pro_unit',
                name: 'pro_unit',
                orderable: false,
                searchable: false
            },
            {
                data: 'date',
                name: 'date',
                orderable: false,
                searchable: false
            },
            {
                data: 'comment',
                name: 'comment',
                orderable: false,
                searchable: false
            },
            ],
            pagingType: 'simple_numbers',
            dom: 'frtip',
             searching: false,
        });
         @else
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
            columnDefs: [
            {
                targets: [0, 4],
                orderable: false,
            },
            { width: "1%", targets: 0 },
            { width: "24%", targets: 1 },
            { width: "25%", targets: 2 },
            { width: "25%", targets: 3 },
            { width: "20%", targets: 4 },
            ],
            ajax: {
                url: admin_url + "customers/product_details_list",
                type: 'post',
                data: {
                    _token: token,
                    product_status:product_status,
                    customer_id:customer_id,

                },
            },
            columns: [
            {
                data: 'ser_id_num',
                name: 'ser_id_num',
                orderable: false,
                searchable: false
            },
            {
                data: 'pro_image',
                name: 'pro_image',
                orderable: false,
                searchable: false

            },
            {
                data: 'pro_name',
                name: 'pro_name',
                orderable: false,
                searchable: false
            },
            {
                data: 'pro_unit',
                name: 'pro_unit',
                orderable: false,
                searchable: false
            },
            {
                data: 'date',
                name: 'date',
                orderable: false,
                searchable: false
            },
            ],
            pagingType: 'simple_numbers',
            dom: 'frtip',
             searching: false,
        });
         @endif

    $("#seach_filter").click(function(){
        $('#clear_filter').css('display','');
            
        if ($('#search_text').val() != '' || $('#from_date').val() != '' || $('#to_date').val() != '') {
          
            var formData = $('#search_daily_status').serialize();
            $.ajax({
            url: '{{route('customers.product_list_search')}}', 
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log(response);
                var newData = response.data;
            
                table.clear().draw();
                newData.forEach(function(item) {
                    if (item.pro_name != '') {
                         table.row.add(item).draw(false);
                    }
                   
                });
            },
            error: function (error) {
                console.error(error);
            }
        });
        } else {
            toastr.error('Please choose one input field')
        }

    });

    $(document).on("click", "#clear_filter", function() {
        $("#search_text").val("");
        $("#from_date").val("");
        $("#to_date").val("");

        table.ajax.reload();
        $('#clear_filter').css('display','none');
    });





 


     })
 $(document).on("click", ".view_comment", function() {
    var cart_id = $(this).data('id');
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
            url: '{{route('view.cart.comment')}}', 
            type: 'POST',
            data: {
                cart_id : cart_id,
                _token: token
            },
            success: function (response) {
                // Handle success response from the server
                if(response.status == 1)
                {
                    $('#show_comment_modal').modal('show');
                    $('#comment_display').text('“'+response.comment+'”');
                }
                
            },
            error: function (error) {
                console.error(error);
            }
        });
 });
 </script>
 @endsection