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
                    <li class="breadcum-item active"><a href="javascript:;"> Delivery Zipcodes </a></li>
                </ul>
            </div>
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <!-- <strong>Category List</strong> -->
                                <h5>Delivery Zipcodes</h5>
                                <a href="{{route('delivery_zip.add')}}" class="add-article-btn">Add Zip Code</a>
                                </div>
                                <div class="card-body card-block px-0 py-3">
                                    @if(session('invalid_zips'))
                                        <p style="color: red;">Invalid Zipcodes: {{ session('invalid_zips') }}</p>
                                    @endif
                                    <form id="search_slider_status" data-parsley-validate>
                                        @csrf
                                        <div class="mb-3 filter-sec">
                                            <div class="row input_group">
                                                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                    <label>Country <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Country"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <select class="form-control select2" name="country" id="country" required data-parsley-required-message="Please Select Country">
                                                        <option selected value="Select">Select</option>
                                                        @if(isset($contries) && count($contries) > 0)
                                                        @foreach($contries as $country_n)
                                                        <option value="{{ $country_n->id }}" {{ isset($country) && $country ==  $country_n->id ? 'selected' : ''}}>{{ $country_n->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span id="error_message" class="error-container"></span>
                                                </div>
                                                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                    <label>State <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select State"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <select class="form-control select2" name="state" id="state" required data-parsley-required-message="Please Select State">
                                            
                                                    </select>
                                                    <span id="error_message" class="error-container"></span>
                                                </div>
                                                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                                    <label>City <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select City"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <select class="form-control select2" name="city" id="city" required data-parsley-required-message="Please Select City">
                                            
                                                    </select>
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
                                                    <th scope="col">Country</th>
                                                    <th scope="col">State</th>
                                                    <th scope="col">City</th>
                                                    <th scope="col">View</th>
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



    @endsection
    @section('script')

    <script>
    $(document).ready(function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var country  = $('#country').val();
        var state = $('#state').val();
        var city = $('#city').val();
        load_zipcodes(country,state,city);
        var table;
        function load_zipcodes(country,state,city)
        {
            if ($.fn.DataTable.isDataTable('#myTable')) {
                table.destroy();
            }
            table = $('#myTable').DataTable({
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
                    sWidth: '25%'
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
                    sWidth: '24%'
                }
            ],
            ajax: {
                url: admin_url + "delivery-zip/list",
                type: 'post',
                data: {
                    _token: token,
                    state : state,
                    country: country,
                    city: city,
                },
            },

            columns: [{
                    data: 'ser_id',
                    name: 'id',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'country.name',
                    name: 'country.name',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'state_count',
                    name: 'state_count',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'city',
                    name: 'city',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'viewcode',
                    name: 'viewcode',
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
        }
        
        

        $("#seach_filter").click(function(){
        $('#clear_filter').css('display','');
        // $('#search_slider_status').parsley().validate();
        if (($('#country').val() !== 'Select' && $('#country').val() !== null) || $('#state').val() !== null || $('#city').val() !== null)  {
            var country  = $('#country').val();
            var state = $('#state').val();
            var city = $('#city').val();
            load_zipcodes(country,state,city);
        
        } else {
            toastr.error('Please choose one input field')
        }

    });
         $(document).on("click", "#clear_filter", function() {
            $('#country').select2('destroy');
        $("#country").val("Select");
        $('#country').select2();
        $("#state").html('');
        $('#city').html('');
        var country  = $('#country').val();
        var state = $('#state').val();
        var city = $('#city').val();
        load_zipcodes(country,state,city);
        $('#clear_filter').css('display','none');

    });
    });
    </script>

        <script>

        $(document).on('click', '#is_featured', function() {
            var token = $("meta[name='csrf-token']").attr("content");
            var id = $(this).attr("data-id");
            var isChecked = $(this).is(':checked');
            $.ajax({
                url: admin_url + "check/featured-delivery_zip",
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
                text: 'You are about to delete the Delivery Zip Code!',
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
        $('#country').on('change', function () { 
        var country = this.value;
          $("#state").html('');
          $.ajax({
            url: "{{route('business.get_state')}}",
            type: "POST",
            data: {
              country: country,
              _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
              $('#state').html('<option value="">Select State</option>');
              $.each(result.state, function(key, value) {
                $("#state").append('<option value="' + value.id + '">' + value.name + '</option>');
              });
            }
          }); 
    });
        $('#state').on('change', function () { 
        var state = this.value;
          $("#city").html('');
          $.ajax({
            url: "{{route('business.get_city')}}",
            type: "POST",
            data: {
              state: state,
              _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
              $('#city').html('<option value="">Select City</option>');
              $.each(result.city, function(key, value) {
                $("#city").append('<option value="' + value.id + '">' + value.name + '</option>');
              });
            }
          }); 
    });
    </script>
 
  
    @endsection