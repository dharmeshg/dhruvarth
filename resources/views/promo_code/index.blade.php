@extends('layouts.backend.index')
@section('main_content')
<style>
    .download-btn{background-color: var(--theme-orange-red); color: #000; padding: 5px; margin-top: 5px; display: inline-block; margin-right: 15px; border-radius: 3px;}
    .swal2-confirm {background-color: var(--theme-orange-red) !important;box-shadow: unset !important;}
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
                                    <h5>Promo code</h5>
                                    <div>
                                        <a href="javascript:;" id="upload_excel" class="add-article-btn" data-bs-toggle="modal" data-bs-target="#upload_promocode_model">Upload Excel</a>
                                        <a href="{{route('promo_code.add')}}" class="add-article-btn">Add Promo code</a>
                                    </div>
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
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label>Discount Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Discount Type for Promocode"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <select class="form-control" id="discount_type" name="status" >
                                                        <option value="2">Please Select</option>
                                                        <option value="amount">Amount</option>
                                                        <option value="percentage">Percentage</option>
                                                    </select>
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label>Status <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select status for Promocode"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="2">Please Select</option>
                                                        <option value="active">Active</option>
                                                        <option value="inactive">InActive</option>
                                                    </select>
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <label>Public Status <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Public status for Promo status"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <select class="form-control" id="public_select" name="status">
                                                        <option value="2">Please Select</option>
                                                        <option value="yes">Enable</option>
                                                        <option value="no">Disable</option>
                                                    </select>
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
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Code</th>
                                                    <th scope="col">Start Date</th>
                                                    <th scope="col">End Date</th>
                                                    <th scope="col">Discount</th>
                                                    <th scope="col">Discount Type</th>
                                                    <th scope="col">No Of Use</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Public</th>
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

<div class="modal fade" id="upload_promocode_model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload Excel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="upload_promocode_form" action="{{ route('promo_code.file_store') }}" method="POST" data-parsley-validate="" enctype="multipart/form-data">
            @csrf
            <div class="modal-body add-article">
                <div class="card-block ">
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                        <a href="{{ asset('sample_files/promocode_upload_sample.xlsx') }}" download="Sample Promocode Upload" class="download-btn"><i class="fa fa-download"></i> Sample File</a>
                        <a href="javascript:;" id="download_categories" class="download-btn"><i class="fa fa-download"></i> Categories</a>
                        <div class="form-sec">
                            <label for="">File <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Choose file"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                            <input type="file" name="file" class="form-control me-2" placeholder="From Date" accept=".xls,.xlsx"  id="file" required data-parsley-required-message="Please select file">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="upload_button" class="btn btn-primary">Upload</button>
            </div>
        </form>
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
                { targets: [0, 10], orderable: false },
                { width: "5%", targets: 0 },
                { width: "15%", targets: 1 },
                { width: "10%", targets: 2 },
                { width: "10%", targets: 3 },
                { width: "10%", targets: 4 },
                { width: "10%", targets: 5 },
                { width: "10%", targets: 6 },
                { width: "10%", targets: 7 },
                { width: "5%", targets: 8 },
                { width: "5%", targets: 9 },
                { width: "10%", targets: 10 },
            ],
            ajax: {
                url: admin_url + "promo-code/list",
                type: 'post',
                data: function(d) {
                    d._token = token;
                    d.search_text = $('#search_text').val();
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                    d.discount_type = $('#discount_type').val();
                    d.status = $('#status').val();
                    d.public_status = $('#public_select').val();
                }
            },
            columns: [
                { data: 'ser_id', name: 'id', orderable: false, searchable: false },
                { data: 'title', name: 'title', orderable: false, searchable: false },
                { data: 'code', name: 'code', orderable: false, searchable: false },
                { data: 'startDate', name: 'startDate', orderable: false, searchable: false },
                { data: 'endDate', name: 'endDate', orderable: false, searchable: false },
                { data: 'discount', name: 'discount', orderable: false, searchable: false },
                { data: 't_discount', name: 't_discount', orderable: false, searchable: false },
                { data: 'no_of_use_d', name: 'no_of_use_d', orderable: false, searchable: false },
                { data: 'p_status', name: 'p_status', orderable: false, searchable: false },
                { data: 'p_publish_status', name: 'p_publish_status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            pagingType: 'simple_numbers'
        });
        

        $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var deleteUrl = $(this).data('href');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to delete the Promo Code!',
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

        $(document).on('click', '.is_featured_class', function() {
            var token = $("meta[name='csrf-token']").attr("content");
            var id = $(this).attr("data-id");
            var type = $(this).attr('data-type');
            var isChecked = $(this).is(':checked');
            $.ajax({
                url: admin_url + "check/featured-promo-code",
                type: "post",
                data: {
                    _token: token,
                    isChecked: isChecked,
                    type: type,
                    id: id,
                },
                success: function(data) {
                    if (data.status == 2) {
                        toastr.success(data.message);
                    } else if (data.status == 1) {
                        toastr.success(data.message);
                    }else if(data.status == 0)
                    {
                        Swal.fire("Opps!", data.message, "error");
                        var checkbox = $('input.is_featured_class[data-id="' + id + '"][data-type="' + type + '"]');
                        checkbox.prop('checked', false);
                    }
                }
            });
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
        $(document).on("click", "#upload_button", function() {
            var form = $('#upload_promocode_form');
            if (form.parsley().validate()) {
                var formData = new FormData(form[0]);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false, 
                    processData: false, 
                    success: function(response) {
                        if(response.status == 1)
                        {
                            if(response.invalid != '')
                            {
                                $('#invalid_message_div').removeClass('d-none');
                                $('#error_p_tag').text(response.invalid);
                            }else{
                                $('#invalid_message_div').addClass('d-none');
                                $('#error_p_tag').text('');
                            }
                            table.ajax.reload();
                            $('#upload_promocode_form')[0].reset();
                            $('#upload_promocode_model').modal('hide');
                        }
                    },
                    error: function(response) {
                        // Handle error - Show an error message
                        $('#upload_promocode_form')[0].reset();
                        $('#upload_promocode_model').modal('hide');
                        toastr.error('Something Went Wrong!')
                    }
                });
            }
        });

        $(document).on('click','#download_categories', function(e){
            $.ajax({
                type: "POST",
                url: '{{ route("promo_code.cats.download") }}',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    if(data != 'blank'){
                    $("#dvjson").excelexportjs({
                        containerid: "dvjson", 
                        datatype: 'json',
                        worksheetName:'Categories list',
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
    });
</script>
@endsection