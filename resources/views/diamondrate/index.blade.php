@extends('layouts.backend.index')
@section('main_content')

    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('daily_update.index')}}">Daily Updates</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Diamond Rate </a></li>
                </ul>
            </div>
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card Recent-Users mb-4">
                                    <div class="card-header">
                                        <h5>Diamond Rate</h5>
                                        <!-- <a href="{{route('promo_code.add')}}" class="add-article-btn">Metal Rate</a> -->
                                        <a href="" class="add-article-btn" data-bs-toggle="modal" data-bs-target="#metal_rate_modal">Add Diamond Rate</a>
                                    </div>
                                    <div class="card-body card-block px-0 py-3">
                                    	<form id="search_metal" data-parsley-validate>
                                    		@csrf
	                                        <div class="mb-3 filter-sec">
	                                            <div class="row input_group">
	                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
	                                                    <label>Search <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please search diamond Type and Quality" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
	                                                    <input type="text" id="search_text" name="search_text" class="form-control" placeholder="Search" data-parsley-required-message="Please Enter Text" data-parsley-errors-container="#error_message" >
	                                                    <span id="error_message" class="error-container"></span>
	                                                </div>
	                                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
	                                                    <label>Date <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Date Range" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                        <div class="row">
                                                           <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                            <input type="text" name="from_date" class="form-control me-2" placeholder="From Date" readonly id="from_date" data-parsley-required-message="Select From Date" data-parsley-errors-container="#error_message2" >
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
                                                  <!--   <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-2 btn-sec">
                                                        <a class="btn" id="clear_filter">X Clear Filter</a>
                                                    </div> -->
	                                            </div>
	                                        </div>
	                                    </form>
                                        <div class="table-responsive" role="tabpanel" id="">
                                            <table class="table table-hover" id="myTable" style="width:100%">
                                                <thead>
                                                    <tr class="unread">
                                                        <th scope="col">Sr.no.</th>
                                                        <th scope="col">Type</th>
                                                        <th scope="col">Quality</th>
                                                        <th scope="col">Rate</th>
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

    <div class="modal fade" id="metal_rate_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCenterTitle">Add Diamond Rate</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="add_metal_rate" action="" method="" data-parsley-validate="" onsubmit="return false">
                @csrf
                <input type="hidden" id="rate_id" name="rate_id">
                <div class="input_group">
                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlTextarea1">Type <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select the type of diamond" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                        <select class="form-select" id="type" name="type"
                        aria-label="Default select example" required
                        data-parsley-required-message="Please Choose type">
                        @if(isset($types))
                        @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlTextarea1">Quality <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Metal Purity From Drop-Down" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                        <select class="form-select" id="quality" name="quality"
                        aria-label="Default select example" required
                        data-parsley-required-message="Please Choose quality">
                        <option value="VVS EF">VVS EF</option>
                        <option value="VVS / VS FG">VVS / VS FG</option>
                        <option value="VVS FG">VVS FG</option>
                        <option value="VS/SI GH">VS/SI GH</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">Rate (Price Per carat) <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert diamond rate per carat" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
                    <input class="form-control" oninput="validateAmount(this)" id="rate" name="rate" type="text" required
                    data-parsley-required-message="Please Enter Rate"
                    placeholder="Diamond Rate">

                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-lg btn-primary">Save</button>
                </div>
            </div>
        </form>
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
	      $('#search_metal').parsley();
        var token = $("meta[name='csrf-token']").attr("content");

        var metal_table = $('#myTable').DataTable({
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
                sWidth: '10%'
            },
            {
                sWidth: '10%'
            },
            {
                sWidth: '20%'
            },
            {
                sWidth: '19%'
            }
            ],
            ajax: {
                url: admin_url + "diamond-rate/list",
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
                data: 'type.name',
                name: 'type.name',
                orderable: false,
                searchable: false
            },
            {
                data: 'quality',
                name: 'quality',
                orderable: false,
                searchable: false
            },
            {
                data: 'rate',
                name: 'rate',
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
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'Action',
                orderable: false,
                searchable: false
            }
            ],
            pagingType: 'simple_numbers',
            dom: 'frtip',
             searching: false,
        });
        
$("#seach_filter").click(function(){
            $('#clear_filter').css('display','');

		// $('#search_metal').parsley().validate();
		if ($('#search_text').val() != '' || $('#from_date').val() != '' || $('#to_date').val() != '') {
			var formData = $('#search_metal').serialize();
			$.ajax({
            url: '{{route('diamondrate.search')}}', 
            type: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response from the server
                var newData = response.data;
                metal_table.clear().rows.add(newData).draw();
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

        $("#add_metal_rate").submit(function(e) {

          var data = new FormData($('#add_metal_rate')[0]);

          $.ajax({
            url: '{{ route('diamondrate.save') }}',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: data,
            success: function (data) {
                if ((data.status = 1)) {
                    $("#metal_rate_modal").modal("toggle");
                    $("#metal_rate_modal form")[0].reset();
                    metal_table.ajax.reload();

                    if (data.status == 1) {
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }

                }
            },
        });

      });


        $("#metal_rate_modal").on("hidden.bs.modal", function () {
            $(this).find("form").trigger("reset");
            // $('#add_metal_rate').parsley('reset');
            $('#add_metal_rate').parsley().reset();
            $("#rate_id").val("");
            $("#modalCenterTitle").html("Add Diamond Rate");
        });


        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var token = $("meta[name='csrf-token']").attr("content");
            var id = $(this).attr("data-id");
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete the Diamond Rate!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: "{{ route('diamondrate.delete') }}",
                    type: "post",
                    data: {
                        _token: token,
                        id: id,
                    },
                    success: function (data) {
                        toastr.error(data.message);
                        metal_table.ajax.reload();
                    },
                });
              }
          });
        });

    $(document).on("click", "#clear_filter", function() {
        $("#search_text").val("");
        $("#from_date").val("");
        $("#to_date").val("");

        metal_table.ajax.reload();
        $('#clear_filter').css('display','none');
    });


    });
</script>
<script>
   function validateAmount(inputField) {
    inputField.value = inputField.value.replace(/[^0-9.]/g, '');

    let decimalCount = (inputField.value.match(/\./g) || []).length;
    if (decimalCount > 1) {
        inputField.value = inputField.value.slice(0, -1);
    }
}
</script>

<script>


    $(document).on("click", ".edit", function() {
        $("#metal_rate_modal").modal("show");
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        $.ajax({
            url: admin_url + "diamond-rate/edit",
            type: "post",
            data: {
                _token: token,
                id: id,
            },
            success: function(data) {
                var data = JSON.parse(data);
                var category_list = data.categories;
                $("#rate_id").val(data.id);
                $("#type").val(data.type);
                $("#quality").val(data.quality);
                $("#rate").val(data.rate);

                $("#modalCenterTitle").html("Edit Diamond Rate");
            },
        });
    });
    $(document).on("click", "#clear", function() {
        $("#rate_id").val("");
        $("#purity").val("");
        $("#rate").val("");
        $("#modalCenterTitle").html("Add Metal Rate");
    });

    $(document).on('click', '#is_featured', function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        var isChecked = $(this).is(':checked');
        var checkbox = $(this);
        $.ajax({
            url: admin_url + "metal-rate/pinned",
            type: "post",
            data: {
                _token: token,
                isChecked: isChecked,
                id: id,
            },
            success: function(data) {
                if (data.pinned == 2) {
                    toastr.success(data.message || data.pinned == 1);
                } 
                else if(data.pinned == 3){
                    checkbox.prop('checked', false);
                    toastr.error(data.message);
                }

            }
        });
    })

    $(document).on('click', '#is_status', function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        var isChecked = $(this).is(':checked');
        $.ajax({
            url: admin_url + "diamond-rate/is_status",
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



</script>
<script>
	
</script>
@endsection