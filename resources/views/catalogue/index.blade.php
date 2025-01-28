@extends('layouts.backend.index')
@section('main_content')

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('product_all.index')}}"> Inventory </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Catalogue</a></li>
                </ul>
            </div>

            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <h5>Catalogue</h5>
                                    <a href="{{route('catalogue.add')}}" class="add-article-btn">Add Catalogue</a>
                                </div>
                                <div class="card-block px-0 py-3">
                                    <form id="search_slider_status" data-parsley-validate>
                                        @csrf
                                        <div class="mb-3 filter-sec">
                                            <div class="row input_group">
                                                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                    <label>Search <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please search from here for catalogue"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="search_text" class="form-control" placeholder="Search" id="search_text">
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label>Date <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Date Range"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <div class="row">
                                                     <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <input type="text" name="from_date" class="form-control me-2" placeholder="From Date" readonly id="from_date"  data-parsley-required-message="Select From Date" data-parsley-errors-container="#error_message2" >
                                                        <span id="error_message2"></span>
                                                    </div> 
                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <input type="text" name="to_date" placeholder="To Date" class="form-control" id="to_date" readonly  data-parsley-required-message="Select To Date" data-parsley-errors-container="#error_message3">
                                                        <span id="error_message3"></span>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                <label>Status <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Visibility Status"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                <select class="form-control" id="status_select" name="status"  data-parsley-required-message="Please Select Status" data-parsley-errors-container="#error_message">
                                                    <option value="2">Please Select</option>
                                                    <option value="1">Enable</option>
                                                    <option value="0">Disable</option>
                                                </select>
                                                <span id="error_message" class="error-container"></span>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 btn-sec" style="margin-top: 28px;">
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
                                                <th scope="col">Sr no.</th>
                                                <th scope="col">Name & Cover Image</th>
                                                <!-- <th scope="col">Destination Link</th> -->
                                                <th scope="col">Date</th>
                                                <th scope="col">Status</th>
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
        var slug = $('#slug').val();
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
                bAutoWidth: false,
                ajax: {
                    url: admin_url + "list-catalogue",
                    type: 'post',
                    data: {
                        _token: token,
                        slug: slug,
                    },
                },

                columns: [{
                    data: 'ser_id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                    width: '1%'
                },
                {
                    data: 'p_title_div',
                    name: 'p_title_div',
                    orderable: false,
                    searchable: false,
                    width: '25%'
                },
                // {
                //     data: 'link',
                //     name: 'link',
                //     orderable: false,
                //     searchable: false,
                //     width: '19%'
                // },
                {
                    data: 'date',
                    name: 'date',
                    orderable: true,
                    searchable: true,
                    width: '5%'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: true,
                    searchable: true,
                    width: '5%'
                },
                {
                    data: 'action',
                    name: 'Action',
                    orderable: false,
                    searchable: false,
                    width: '20%'
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
            $("#search_text").val("");
            table.ajax.reload();
            $('#clear_filter').css('display','none');

        });
        
        $("#seach_filter").click(function(){
            $('#clear_filter').css('display','');
            // $('#search_slider_status').parsley().validate();
            if ($('#search_text').val() != '' || $('#status_select').val() != '2' || $('#from_date').val() != '' || $('#to_date').val() != '') {
                var formData = $('#search_slider_status').serialize();
                $.ajax({
                url: '{{route('catalogue.filter')}}', 
                type: 'POST',
                data: formData,
                success: function (response) {
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

    });


    $(document).on('click', '#is_featured', function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        var isChecked = $(this).is(':checked');
        $.ajax({
            url: admin_url + "catalogue-status",
            type: "post",
            data: {
                _token: token,
                isChecked: isChecked,
                id: id,
            },
            success: function(data) {
                if (data.status == 2) {
                    toastr.success(data.message);
                } else if (data.status == 1) {
                    toastr.success(data.message);
                }

            }
        });
    })


    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).data('href');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete the Catalogue!',
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


@endsection
