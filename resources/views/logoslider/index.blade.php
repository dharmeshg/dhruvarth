@extends('layouts.backend.index')
@section('main_content')

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('media.index')}}"> Media </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Logo List</a></li>
                </ul>
            </div>
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <!-- <strong id="modalCenterTitle">Add New Category</strong> -->
                                    <h5 id="modalCenterTitle">{{isset($sec_title->title) ? $sec_title->title : 'Logo'}} List</h5>
                                    <input type="hidden" name="slug" id="slug" value="{{ isset($slug) ? $slug : '' }}">
                                    <div>
                                        <a href="{{route('logoslider.add',['sec' => $slug])}}" class="add-article-btn">Add Logo</a>
                                        <a href="{{route('media.section',['sec' => 'logo-slider'])}}" class="add-article-btn">Back To Sections</a>
                                    </div>
                                </div>
                                <div class="card-body card-block px-0 py-3">
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">Sr.No.</th>
                                                    <th scope="col">Cover Image</th>
                                                    <th scope="col">Title</th>
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

    @endsection
    @section('script')

    <script>
    $(document).ready(function() {
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
                    sWidth: '24%'
                }
            ],
            ajax: {
                url: admin_url + "list-logo-sliders",
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
                    searchable: true
                },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'title',
                    name: 'title',
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
                    data: 'status',
                    name: 'status',
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
            url: admin_url + "status-logo-sliders",
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
            text: 'You are about to delete the Logo Slider!',
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