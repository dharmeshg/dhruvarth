@extends('layouts.backend.index')
@section('main_content')
<style>
    .datepicker-days{display: block !important;}
</style>
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Products </a></li>
                </ul>
            </div>
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <h5>Products</h5>
                                    <div>
                                    <a href="{{route('product.quickadd')}}" class="add-article-btn">Quick Add Product</a>
                                    <a href="{{route('product.add')}}" class="add-article-btn">Add Product</a>
                                    </div>
                                </div>
                                <input type="hidden" name="" id="gemstone" value="{{$gemstone}}">
                                <div class="card-body card-block px-0 py-3">
                                    <form id="search_slider_status" data-parsley-validate>
                                        @csrf
                                        <div class="mb-3 filter-sec">
                                            <div class="row input_group">
                                                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                    <label>Search <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please search from here for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="search_text" class="form-control" placeholder="Search" id="search_text">
                                                </div>
                                                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                    <label>Product Category <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select product category "><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <select class="form-control" id="catgory_select" name="category"  data-parsley-required-message="Please Select Status" data-parsley-errors-container="#error_message">
                                                        <option value="all">All</option>
                                                        @if(isset($categories) && count($categories) > 0)
                                                        @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->category }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span id="error_message" class="error-container"></span>
                                                </div>
                                                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                    <label>Status <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select status for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <select class="form-control" id="status_select" name="status"  data-parsley-required-message="Please Select Status" data-parsley-errors-container="#error_message">
                                                        <option value="2">Please Select</option>
                                                        <option value="ready_stock">Ready Stock</option>
                                                        <option value="by_order">By Order</option>
                                                    </select>
                                                    <span id="error_message" class="error-container"></span>
                                                </div>
                                                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 btn-sec" style="margin-top: 28px;">
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
                                                    <th scope="col">#</th>
                                                    <th scope="col">Product Name</th>
                                                    <th scope="col">Product Category</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">SKU No.</th>
                                                    <th scope="col">Product Status</th>
                                                    <th scope="col">Visibility</th>
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
          $('#search_slider_status').parsley();
        var token = $("meta[name='csrf-token']").attr("content");

            var table = $('#myTable').DataTable({
                language: {
                    search: "",
                    "searchPlaceholder": "Search",
                    "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>',
                    paginate: {
                            next: 'Next', // 'Next' label for the next button
                            previous: 'Previous'
                    }
                },
                processing: true,
                serverSide: true,
                bAutoWidth: false,
                aoColumns: [{
                        sWidth: '1%'
                    },
                    {
                        sWidth: '40%'
                    },
                    {
                        sWidth: '10%'
                    },
                    {
                        sWidth: '5%'
                    },
                    {
                        sWidth: '10%'
                    },
                    {
                        sWidth: '10%'
                    },
                    {
                        sWidth: '24%'
                    }
                ],
                ajax: {
                    url: admin_url + "product-list",
                    type: 'post',
                    data: {
                        _token: token,
                    },
                },

                columns: [{
                        data: 'ser_id',
                        name: 'id',
                        width: '1%'
                    },
                    {
                        data: 'p_title_div',
                        name: 'p_title_div',
                        width: '40%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'cat',
                        name: 'cat',
                        width: '10%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'price',
                        name: 'price',
                        width: '10%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'p_sku',
                        name: 'p_sku',
                        width: '10%',
                        orderable: true,
                        searchable: true
                    },
                     {
                        data: 'p_status',
                        name: 'p_status',
                        width: '10%',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'visiblity',
                        name: 'visiblity',
                        width: '10%',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'Action',
                        width: '10%',
                        orderable: false,
                        searchable: false
                    }
                ],

                pagingType: 'simple_numbers',
                dom: 'frtip',
                 searching: false,
            });

    $(document).on("click", "#clear_filter", function() {
        $("#status_select").val("2");
        $("#from_date").val("");
        $("#to_date").val("");

        table.ajax.reload();
        $('#clear_filter').css('display','none');

    });
    $("#seach_filter").click(function(){
        $('#clear_filter').css('display','');
        // $('#search_slider_status').parsley().validate();
        if ($('#search_text').val() != '2' || $('#status_select').val() != '' || $('#catgory_select').val() != '') {
            var formData = $('#search_slider_status').serialize();
            $.ajax({
            url: '{{route('product.filter')}}', 
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
            toastr.error('Please choose one input field')
        }

    });

    var gemstone = $('#gemstone').val();

        if (gemstone == 'Gemstone') {
            $('#catgory_select').val('9');
            // $("#seach_filter").trigger("click");
            setTimeout(function() {
            $("#seach_filter").trigger("click");
        }, 150);
        }

    });
    </script>
    <script>
    $(document).on('click', '#visiblity', function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        var isChecked = $(this).is(':checked');
        $.ajax({
            url: admin_url + "product-status",
            type: "post",
            data: {
                _token: token,
                isChecked: isChecked,
                id: id,
            },
            success: function(data) {
                toastr.success(data.message);
            }
        });
    })


    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).data('href');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete the Product!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }
        });
    });

    </script>
  <!--   <script>
         $(document).ready(function() {
                   var gemstone = $('#gemstone').val();

        if (gemstone == 'Gemstone') {
            $('#catgory_select').val('9');
            $("#seach_filter").trigger("click");
        }
         })
    </script> -->
@endsection
