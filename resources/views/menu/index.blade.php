@extends('layouts.backend.index')

@section('main_content')
<style>
.card .card-header .add-article-btn {
  border: none;
}
</style>

    <div class="pcoded-wrapper">

        <div class="pcoded-content">

            <div class="pcoded-inner-content">

                <!-- [ breadcrumb ] start -->



                <!-- [ breadcrumb ] end -->

                <div class="main-body">

                    <div class="page-wrapper">

                        <!-- [ Main Content ] start -->

                        <div class="row ">

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <div class="card Recent-Users mb-4">

                                    <div class="card-header">

                                        <h5>Menu</h5>



                                        <button class="add-article-btn" id="add_menu">Add Menu</button>

                                    </div>

                                    <div class="card-block px-0 py-3">

                                        <div class="table-responsive" role="tabpanel" id="">

                                            <table class="table table-hover" id="myTable" style="width:100%">

                                                <thead>

                                                    <tr class="unread">

                                                        <th scope="col">#</th>

                                                        <th scope="col">Name</th>

                                                        <th scope="col">Header Menu</th>

                                                        <th scope="col">Footer Quick Links</th>

                                                        <th scope="col">Footer services</th>

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

    @include('menu.modal')


        @endsection

        @section('script')

            <script>

                $(document).ready(function() {
                    var token = $("meta[name='csrf-token']").attr("content");
                    var table = $('#myTable').DataTable({
                        language: {
                            search: "",
                            "searchPlaceholder": "Search",
                            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>',
                            paginate: {
                                next: '&gt;',
                                previous: '&lt;'
                            }
                        },
                        processing: true,
                        autoWidth: false,
                        columnDefs: [
                            { 
                                targets: [0, 5],
                                 orderable: false,
                            },
                            {
                                width: '1%', targets: 0 
                            },
                            {
                                width: '20%', targets: 1 
                            },
                            {
                                width: '20%', targets: 2 
                            },
                            {
                                width: '20%', targets: 3 
                            },
                            {
                                width: '20%', targets: 4 
                            },
                            {
                                width: '19%', targets: 5 
                            }
                        ],
                        ajax: {
                            url: admin_url + "list-menu",
                            type: 'post',
                            data: {
                                _token: token,
                            },
                        },

                        columns: [{
                                data: 'ser_id',
                                name: 'id'
                            },
                            {
                                data: 'display_location',
                                name: 'display_location'
                            },
                             {
                                data: 'header_menu',
                                name: 'header_menu'
                            },
                             {
                                data: 'footre_quick_links',
                                name: 'footre_quick_links'
                            },
                             {
                                data: 'footre_services',
                                name: 'footre_services'
                            },
                            {
                                data: 'action',
                                name: 'Action'
                            }
                        ]
                    });
                });

                $(document).on('click', '#add_menu', function() {
                    $("#add_menu_modal").show();
                });

                 $(document).on('click', '#add_menu', function() {
                    $("#add_menu_modal").modal('show');
                });


                $(document).on('click', '.menu_delete', function(e) {
                    e.preventDefault();
                    var deleteUrl = $(this).data('href');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to delete the Menu!',
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

                $(document).on('click', '.display_menu', function() {
                    var token = $("meta[name='csrf-token']").attr("content");
                    var id = $(this).attr("data-id");
                    var isChecked = $(this).is(':checked');
                    var display_location = $(this).attr('data-val');

                    $.ajax({
                        url: '{{ route('menu.display_location') }}',
                        type: "post",
                        data: {
                            _token: token,
                            isChecked: isChecked,
                            id: id,
                            display_location: display_location,
                        },
                        success: function(data) {
                            if (data.status == 2) {
                                toastr.success(data.message);
                            } else if (data.status == 1) {
                                toastr.success(data.message);
                            }

                        }
                    });
                });

            </script>

        @endsection

