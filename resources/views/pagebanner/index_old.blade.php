@extends('layouts.backend.index')
@section('main_content')

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('media.index')}}"> Media </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Page Banners</a></li>
                </ul>
            </div>
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <h5>Page Banner List</h5>
                                    <input type="hidden" name="slug" id="slug" value="{{ isset($slug) ? $slug : '' }}">
                                     <div>
                                        <a href="{{route('pagebanner.add',['sec' => $slug])}}" class="add-article-btn">Add Page Banner</a>
                                        <a href="{{route('media.section',['sec' => 'page-banner'])}}" class="add-article-btn">Back To Sections</a>
                                    </div>
                                </div>
                                <div class="card-block px-0 py-3">

                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">Sr.No.</th>
                                                    <th scope="col">Cover Image</th>
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
                url: admin_url + "list-page-banner",
                type: 'post',
                data: {
                    _token: token,
                    slug: slug,
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
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'Action'
                }
            ]
        });


    });
    </script>
    <script>
    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).data('href');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete the Page Banner!',
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
    const dummy = "{{asset('assets/images/user/img-demo_1041.jpg')}}";

    $(document).on("click", ".edit", function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        $.ajax({
            url: admin_url + "edit-page-banner",
            type: "post",
            data: {
                _token: token,
                id: id,
            },
            success: function(response) {
                if(response.status == 'success')
                {
                    var data = response.data;
                    $("#p_banner_id").val(data.id);
                    $("#cover_old_img").val(data.cover_image);
                    $("#cover-item-img-output").attr('src', data.img_url);
                    $("#modalCenterTitle").html("Edit Page Banner");
                }else{
                    toastr.error(response.message);
                }
                // $("#slug").prop("readonly", true);
            },
        });
    });
    $(document).on("click", "#clear", function() {
        $("#p_banner_id").val("");
        $("#cover_old_img").val("");
        $("#cover-item-img-output").attr('src', dummy);
        $("#modalCenterTitle").html("Add New Page Banner");

    })

    $(document).on('click', '#is_featured', function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        var isChecked = $(this).is(':checked');
        $.ajax({
            url: admin_url + "status-page-banner",
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
    </script>
    <script>
        $('#addcategory').on('submit', function (e) {
            if ($('#addcategory').parsley().isValid() && ($('#cover_image_new').val() != '') || $('#cover_old_img').val() != '') {
               $('#addcategory').submit();
            } else {
                $('#error-message').show();
                e.preventDefault(); 
            }
        });
    </script>


@endsection
