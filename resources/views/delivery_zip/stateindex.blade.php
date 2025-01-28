@extends('layouts.backend.index')
@section('main_content')

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="javascript:;"> Settings </a></li>
                    <li class="breadcum-item"><a href="{{route('global_settings.index')}}">Global Settings</a></li>
                    <li class="breadcum-item"><a href="{{route('delivery_zip.index')}}"> Shipping</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> {{ $state->name }}</a></li>
                </ul>
            </div>
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <!-- <strong>Category List</strong> -->
                                <h5>Delivery Zip Codes of {{ $state->name }} - {{ $city->name }}</h5>
                                <a href="{{route('delivery_zip.index')}}" class="back-btn">Back to Zip Codes</a>
                                </div>
                                <div class="card-body card-block px-0 py-3">
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Country</th>
                                                    <th scope="col">State</th>
                                                    <th scope="col">City</th>
                                                    <th scope="col">Code</th>
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
        var state_id = '{{ $state->id }}';
        var city_id = '{{ $city->id }}';
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
            aoColumns: [{
                    sWidth: '1%'
                },
                {
                    sWidth: '25%'
                },
                {
                    sWidth: '25%'
                },
                {
                    sWidth: '25%'
                },
                {
                    sWidth: '15%'
                },
                {
                    sWidth: '10%'
                }
            ],
            ajax: {
                url: admin_url + "delivery-zip-by-state/list",
                type: 'post',
                data: {
                    _token: token,
                    state_id: state_id,
                    city_id: city_id,
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
                    data: 'get_state.name',
                    name: 'get_state.name',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'get_city.name',
                    name: 'get_city.name',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'code',
                    name: 'code',
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
    </script>
 
  
    @endsection