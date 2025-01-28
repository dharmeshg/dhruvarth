@extends('layouts.backend.index')
@section('main_content')
<style>
    .datepicker-days{display: block !important;}
    #suggested_tags{
        position: absolute;
        z-index: 1;
        background-color: #fff;
        width: 363px;
        min-height: 0px;
        max-height: 250px;
        overflow-y: auto;
        list-style: none;
        color: #000;
    }
    .suggested_tags.active{border: 1px solid #aaa;}
    #suggested_tags li{    cursor: pointer;
    padding: 4px 6px;
    font-size: 15px;}
    #suggested_tags li:hover{background-color: var(--theme-orange-red);}
    #myTable_wrapper .top{display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;}
</style>
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('product_all.index')}}">Inventory</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Product </a></li>
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
                                    <button style="display:none;" class="btn table-filter-btn" type="button" id="seach_filter_extra"></button>
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
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label>Search <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please search from here for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="search_text" class="form-control" placeholder="Search" id="search_text">
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
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
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label>Product Family <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select product category "><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <select class="form-control" id="family_select" name="category"  data-parsley-required-message="Please Select Status" data-parsley-errors-container="#error_message">
                                                    <option value="all">All</option>
                                                    @if(isset($families) && count($families) > 0)
                                                    @foreach($families as $fam)
                                                    <option value="{{ $fam->id }}">{{ $fam->family }}</option>
                                                    @endforeach
                                                    @endif
                                                    </select>
                                                    <span id="error_message" class="error-container"></span>
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label>Product Status <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Visibility Status"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <select class="form-control" id="status_select" name="status"  data-parsley-required-message="Please Select Status" data-parsley-errors-container="#error_message">
                                                        <option value="2">Please Select</option>
                                                        <option value="ready_stock">Ready Stock</option>
                                                        <option value="by_order">By Order</option>
                                                        <option value="sold_out">Sold Out</option>
                                                    </select>
                                                    <span id="error_message" class="error-container"></span>
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label>Visibility <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select status for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <select class="form-control" id="visibility_select" name="status"  data-parsley-required-message="Please Select Status" data-parsley-errors-container="#error_message">
                                                        <option value="2">Please Select</option>
                                                        <option value="enable">Enable</option>
                                                        <option value="disable">Disable</option>
                                                    </select>
                                                    <span id="error_message" class="error-container"></span>
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label>Public <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Public status for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <select class="form-control" id="public_select" name="status"  data-parsley-required-message="Please Select Status" data-parsley-errors-container="#error_message">
                                                        <option value="2">Please Select</option>
                                                        <option value="enable">Public</option>
                                                        <option value="disable">Private</option>
                                                    </select>
                                                    <span id="error_message" class="error-container"></span>
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label>Tags <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select tag for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="tag_search" class="form-control" placeholder="Search Tag" id="tag_serch">
                                                    <div id="suggested_tags" class="suggested_tags"></div>
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 btn-sec" style="margin-top: 28px;">
                                                    <button class="btn table-filter-btn" type="button" id="seach_filter">Filter</button>
                                                    <a class="btn" style="color: #DE5757; display: none;" id="clear_filter">X Clear Filter</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover display" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Category</th>
                                                    <th scope="col">Family</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">SKU No.</th>
                                                    <th scope="col">Stock</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col"><img src="{{asset('images/dashbord/Eye image.png')}}" class="image-fuild w-auto" alt="user-img"></th>
                                                    <th scope="col">Public</th>
                                                    <th scope="col">Variant</th>
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
@include('products.attributes_model')
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
          var tags = [];
          function updateTags(data) {
            tags = data;
            }
          $.ajax({
                url: admin_url + "get-tags",
                type: "post",
                data: {
                    _token: token,
                },
                success: function(data) {
                    updateTags(data.tags);
                }
            });
          function filterTags(searchQuery) {
            // Filter tags based on searchQuery
            var filteredTags = tags.filter(function(tag) {
                return tag.name.toLowerCase().includes(searchQuery.toLowerCase());
            });

            return filteredTags;
        }
        $('#tag_serch').on('keyup', function() {
            var searchQuery = $(this).val(); // Get search query from input
            var filteredTags = filterTags(searchQuery); // Filter tags based on search query
            if (searchQuery.trim() === '') {
                $('#suggested_tags').removeClass('active').empty();
            } else {
                $('#suggested_tags').addClass('active').empty();
                filteredTags.forEach(function(tag) {
                    $('#suggested_tags').append('<li class="search_tag" data-value="'+ tag.name +'">' + tag.name + '</li>');
                });
            }
        });
        $(document).on("click", ".search_tag", function() {
            var value = $(this).data('value');
            $('#suggested_tags').removeClass('active').empty();
            $('#tag_serch').val(value);
        });

          $('#search_slider_status').parsley();
            var token = $("meta[name='csrf-token']").attr("content");
            var search_text = $('#search_text').val();
            var category  = $('#catgory_select').val();
            var family = $('#family_select').val();
            var status = $('#status_select').val();
            var visibility = $('#visibility_select').val();
            var public_status = $('#public_select').val();
            var tag = $('#tag_serch').val();
            var entry = 10;
            load_products(search_text,category,status,family,visibility,public_status,tag);
            var table;
            function load_products(search_text,category,status,family,visibility,public_status,tag)
            {
                $('#myTable tbody').hide();
                table = $('#myTable').DataTable({
                responsive: true,
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
                searching: false,
                destroy: true,
                ajax: {
                    url: admin_url + "product-list",
                    type: 'post',
                    data: {
                        _token: token,
                        search_text: search_text,
                        category: category,
                        status: status,
                        family: family,
                        visibility: visibility,
                        public_status: public_status,
                        tag: tag,
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
                        width: '30%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'cat',
                        name: 'cat',
                        width: '8%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'fam',
                        name: 'fam',
                        width: '8%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'price',
                        name: 'price',
                        width: '14%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'p_sku',
                        name: 'p_sku',
                        width: '7%',
                        orderable: false,
                        searchable: true
                    },
                     {
                        data: 'p_status',
                        name: 'p_status',
                        width: '8%',
                        orderable: false,
                        searchable: true
                    },
                     {
                        data: 'd_status',
                        name: 'd_status',
                        width: '3%',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'visiblity',
                        name: 'visiblity',
                        width: '2%',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'public_private',
                        name: 'public_private',
                        width: '5%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'variant',
                        name: 'variant',
                        width: '5%',
                        orderable: false,
                        searchable: false
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
                // dom: 'frtip',
                lengthMenu: [10, 50, 100, 250, 500],
                dom: '<"top"l<"dt-buttons"f>>rt<"bottom"ip><"clear">', // Custom DOM structure
                initComplete: function(settings, json) {
                    // Show table body once data is loaded
                    $('#myTable tbody').show();

                    // Replace the default search box with your custom button
                    var searchBox = $('.dt-buttons');
                    searchBox.html('<button class="btn table-filter-btn" type="button" id="export_xml">Export Xml</button>');
                }
            });
            }


     $(document).on('click', '#visiblity', function() {
    
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        var type = $(this).attr("data-type");
        // alert(id);
        // var isChecked = $(this).is(':checked');
        $.ajax({
            url: admin_url + "product-status",
            type: "post",
            data: {
                _token: token,
                // isChecked: isChecked,
                id: id,
                type: type,
            },
            success: function(data) {
            toastr.success(data.message);
            }
        });
    });  
    $(document).on('click', '#public_private', function() {
    
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        var type = $(this).attr("data-type");
        // alert(id);
        // var isChecked = $(this).is(':checked');
        $.ajax({
            url: admin_url + "public-status",
            type: "post",
            data: {
                _token: token,
                // isChecked: isChecked,
                id: id,
                type: type,
            },
            success: function(data) {
            toastr.success(data.message);
            }
        });
    });    

    $(document).on("click", "#clear_filter", function() {
        $("#status_select").val("2");
        $("#search_text").val("");
        $("#catgory_select").val("all");
        $('#family_select').val('all');
        $('#visibility_select').val('2');
        $('#public_select').val('2');
        $('#tag_serch').val('');
        var status = $("#status_select").val();
        var search_text = $("#search_text").val();
        var category = $("#catgory_select").val();
        var family = $('#family_select').val();
        var visibility = $('#visibility_select').val();
        var public_status = $('#public_select').val();
        var tag = $('#tag_serch').val();
        load_products(search_text,category,status,family,visibility,public_status,tag);
        $('#clear_filter').css('display','none');

    });
    $("#seach_filter").click(function(){
        $('#clear_filter').css('display','');
        // $('#search_slider_status').parsley().validate();
        if ($('#search_text').val() != '2' || $('#status_select').val() != '' || $('#catgory_select').val() != '') {
            var search_text = $('#search_text').val();
            var category  = $('#catgory_select').val();
            var family = $('#family_select').val();
            var status = $('#status_select').val();
            var visibility = $('#visibility_select').val();
            var public_status = $('#public_select').val();
            var tag = $('#tag_serch').val();
            load_products(search_text,category,status,family,visibility,public_status,tag);
        
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
    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).data('href');
        var product_id = $(this).data('id');
        $.ajax({
            url: admin_url +"check-variant-exists",
            type: "POST",
            data: {
                product_id: product_id,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            dataType: 'json',
            success: function(result) {
                if(result.status == 1)
                {
                    var message = 'You are about to delete a product that contains variants; this action will also delete the variants associated with it.';
                }else{
                    var message = 'You are about to delete the Product!';
                }
                Swal.fire({
                    title: 'Are you sure?',
                    text: message,
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
            }
        }); 
    });

     $(document).on("change", "#catgory_select", function() {
            var cat = this.value;
            $("#family_select").html('');
            $.ajax({
                url: admin_url +"get-families",
                type: "POST",
                data: {
                    cat: cat,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: 'json',
                success: function(result) {
                    $('#family_select').html('<option value="all">All</option>');
                    $.each(result.families, function(key, value) {
                        $("#family_select").append('<option value="' + value.id + '">' + value.family + '</option>');
                    });
                }
            }); 
        });

        $(document).on("click", ".add_variant", function() {
            var v_product_id = $(this).data('id');
            $('#variant_product_id').val(v_product_id);
            $('#add_variant_model').find('input[type="checkbox"]').prop('checked', false);
            $('.diamond_attr_options').addClass('d-none');
            $('.pearl_attr_options').addClass('d-none');
            $('.gemstone_attr_options').addClass('d-none');
            $('#add_variant_model').modal('show');
        });
        $(document).on("change", "#diamond", function() {
            if(this.checked) {
                $('.diamond_attr_options').removeClass('d-none');
            }else{
                $('.diamond_attr_options').addClass('d-none');
            }
        });
        $(document).on("change", "#pearl", function() {
            if(this.checked) {
                $('.pearl_attr_options').removeClass('d-none');
            }else{
                $('.pearl_attr_options').addClass('d-none');
            }
        });
        $(document).on("change", "#gemstone_main", function() {
            if(this.checked) {
                $('.gemstone_attr_options').removeClass('d-none');
            }else{
                $('.gemstone_attr_options').addClass('d-none');
            }
        });
        $(document).on("click", "#save_v_changes", function() {
            if ($(".attribute_div input[type='checkbox']:checked").length == 0) {
                toastr.error('Please select at least one attribute.');
                return false; // Prevent the AJAX request from being sent
            }
            var formData = $("#add_variant_form").serialize();
            $.ajax({
                url: '{{ route('product.store.variant') }}', 
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Handle success response
                    $('#add_variant_model').modal('hide');
                    if(response.status == 1)
                    {
                        toastr.success(response.message);
                    }else{
                        toastr.error(response.message);
                    }
                    $("#add_variant_form")[0].reset();
                    $('#myTable').DataTable().ajax.reload();
                    
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    toastr.error('An error occurred while saving data.');
                }
            });
        });
        $('#add_variant_model').on('shown.bs.modal', function () {
            $('#variant_child_product').select2({
                dropdownParent: $('#add_variant_model')
            });
        });

        $(document).on('click', '#export_xml', function() {
            var type = 'simple';
            $.ajax({
                url: '{{ route('product.download.xml') }}', 
                type: 'POST',
                data: {
                    type: type,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.file_url) {
                        var link = document.createElement('a');
                        link.href = response.file_url;
                        link.download = response.file_url.split('/').pop(); // Extract the file name from the path
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    toastr.error('An error occurred while saving data.');
                }
            });
        });
    </script>
@endsection
