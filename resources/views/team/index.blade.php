@extends('layouts.backend.index')
@section('main_content')
    <style>
        .article_heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        input[type="checkbox"] {
            position: relative;
            appearance: none;
            width: 35px;
            height: 15px;
            background: #ccc;
            border-radius: 50px;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: 0.4s;
        }

        input:checked[type="checkbox"] {
            background: #321fdb;
        }

        input[type="checkbox"]::after {
            position: absolute;
            content: "";
            width: 18px;
            height: 15px;
            top: 0;
            left: 0;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            transform: scale(1.1);
            transition: 0.4s;
        }

        input:checked[type="checkbox"]::after {
            left: 50%;
        }
    </style>
    <div class="row ">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-header article_heading">
                    <strong id="modalCenterTitle">All Members</strong>
                    <a href="{{ route('team.add') }}"><button type="button" class="btn btn-outline-primary">Add
                        Member</button></a>
                </div>
                <div class="card-body">
                    <div class="example">

                        <div class="tab-content rounded-bottom">
                            <div class="tab-pane p-3 active preview table-responsive" role="tabpanel" id="">
                                <table class="table table-striped" id="myTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">E-Mail</th>
                                            <th scope="col">Featured</th>
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
                bAutoWidth: false,
                aoColumns: [{
                        sWidth: '1%'
                    },
                    {
                        sWidth: '15%'
                    },
                    {
                        sWidth: '35%'
                    },
                    {
                        sWidth: '10%'
                    },
                    {
                        sWidth: '10%'
                    },
                    {
                        sWidth: '10%'
                    },
                    {
                        sWidth: '4%'
                    },
                    {
                        sWidth: '15%'
                    }
                ],
                ajax: {
                    url: admin_url + "list-testimonials",
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
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'featured',
                        name: 'featured'
                    },
                    {
                        data: 'action',
                        name: 'Action'
                    }
                ]
            });

            $(document).on('click', '.testi_delete', function(e) {
                e.preventDefault();
                var deleteUrl = $(this).data('href');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to delete the Articles!',
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

            $(document).on('click', '#is_featured', function() {
                var token = $("meta[name='csrf-token']").attr("content");
                var id = $(this).attr("data-id");
                var isChecked = $(this).is(':checked');
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
        });
    </script>
@endsection
