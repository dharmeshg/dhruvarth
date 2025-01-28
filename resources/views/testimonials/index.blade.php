@extends('layouts.backend.index')

@section('main_content')
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('setting_all.index')}}"> Settings </a></li>
                    <li class="breadcum-item"><a href="{{route('global_settings.index')}}">Global Settings</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Testimonials</a></li>
                </ul>
            </div>
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row ">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card Recent-Users mb-4">
                        <div class="card-header">
                            <!-- <strong>Category List</strong> -->
                            <h5>Testimonial </h5>
                            <a href="{{route('testimonials.add')}}" class="add-article-btn">Add Testimonial</a>
                        </div>
                        <div class="card-body card-block px-0 py-3">
                            <form id="search_testi_status" data-parsley-validate>
                                            @csrf
                                            <p style="color: #8f8888; font-weight: 800; font-style: italic;">*Note: On the frontend, only 12 testimonials will be displayed at a time. If there are more than 12 testimonials, the additional ones will be shown randomly.</p>
                                            <div class="mb-3 filter-sec">
                                                <div class="row input_group">
                                                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                        <label>Search <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Search From Here For Testimonial" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                        <input type="text" id="search_text" name="search_text" class="form-control" placeholder="Search" data-parsley-required-message="Please Enter Text" data-parsley-errors-container="#error_message" >
                                                        <span id="error_message" class="error-container"></span>
                                                    </div>
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                        <label>Date <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Date For Testimonial" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                        <div class="row">
                                                           <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                            <input type="text" name="from_date" class="form-control me-2" placeholder="From Date" readonly id="from_date"  data-parsley-required-message="Select From Date" data-parsley-errors-container="#error_message2" >
                                                            <span id="error_message2"></span>
                                                           </div> 
                                                           <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding-left: 0;">
                                                            <input type="text" name="to_date" placeholder="To Date" class="form-control" id="to_date" readonly data-parsley-required-message="Select To Date" data-parsley-errors-container="#error_message3">
                                                            <span id="error_message3"></span>
                                                           </div> 
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                        <label>Status <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Status For Testimonial" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                        <select class="form-control" name="status" id="status_select" data-parsley-required-message="Please Select Status" data-parsley-errors-container="#error_message4">
                                                            <option selected disabled value="1">Select</option>
                                                            <option value="1">Enable</option>
                                                            <option value="0">Disable</option>
                                                        </select>
                                                        <span id="error_message4" class="error-container"></span>
                                                    </div>
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-sec">
                                                        <button class="btn table-filter-btn" type="button" id="search_filter">Filter</button>
                                                        <a class="btn" style="color: #DE5757; display: none;" id="clear_filter">X Clear Filter</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                            <div class="table-responsive" role="tabpanel" id="">
                                <table class="table table-hover" id="tags_table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr.No.</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col">City</th>
                                            <th scope="col">Rating</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Enable/Disable</th>
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
          $('#search_testi_status').parsley();
            var token = $("meta[name='csrf-token']").attr("content");
            var table = $('#tags_table').DataTable({
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
                aoColumns: [{
                    sWidth: '1%'
                },
                {
                    sWidth: '20%'
                },
                {
                    sWidth: '20%'
                },
                {
                    sWidth: '20%'
                },
                {
                    sWidth: '10%'
                },
                {
                    sWidth: '10%'
                },
                {
                    sWidth: '19%'
                }
                ],
                ajax: {
                    url: admin_url + "testimonials/list",
                    type: 'post',
                    data: {
                        _token: token,
                    },
                },

                columns: [{
                    data: 'ser_id',
                    name: 'id',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'name',
                    name: 'Name',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'phone',
                    name: 'phone',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'rating',
                    name: 'Rating',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'date',
                    name: 'date',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'is_featured',
                    name: 'is_featured',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'Action',
                    orderable: false,
                    searchable: true
                }
                ],
                pagingType: 'simple_numbers',
                dom: 'frtip',
             searching: false,
            });
   
   
$("#search_filter").click(function(){
    $('#clear_filter').css('display','');

    if ($('#search_text').val() != '' || $('#from_date').val() != '' || $('#to_date').val() != '' || $('#status_select').val() != null) {
        
        var formData = $('#search_testi_status').serialize();
        $.ajax({
            url: '{{route('testimonials.search')}}', 
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log(response);
                var newData = response.data;
                table.clear().rows.add(newData).draw();
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
    $("#status_select").val("2");
    $("#from_date").val("");
    $("#to_date").val("");
    $("#status_select").val("").trigger("change");

    table.ajax.reload();
    $('#clear_filter').css('display','none');
});
        })
    </script>

    <script>

        $(document).on('click', '#is_featured', function() {
            var token = $("meta[name='csrf-token']").attr("content");
            var id = $(this).attr("data-id");
            var isChecked = $(this).is(':checked');
            var checkbox = $(this);
            $.ajax({
                url: admin_url + "check/featured-testimonials",
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
        
        $(document).on('click', '.view_comment', function() {
            var token = $("meta[name='csrf-token']").attr("content");
            var id = $(this).attr("data-id");
            $.ajax({
                url: admin_url + "testimonials/comment",
                type: "post",
                data: {
                    _token: token,
                    id: id,
                },
                success: function(data) {
                    
                    $('#show_comment_modal').modal('show');
                    $('#comment_display').text('“'+data.comment.sub_content+'”');
                    $('#name_display').text('- '+data.comment.name);
                }
            });
        })

        $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).data('href');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete the Testimonial !',
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
