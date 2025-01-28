@extends('layouts.backend.index')
@section('main_content')

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">

            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <!-- <strong id="modalCenterTitle">Add New Category</strong> -->
                                    <h5 id="modalCenterTitle">Add New Logo Slider</h5>

                                </div>  
                                <div class="card-body">
                                    <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                                        <form id="addcategory" action="{{ route('logoslider.save') }}" method="POST"
                                            data-parsley-validate="">
                                            @csrf
                                            <input type="hidden" id="logo_id" name="logo_id">
                                            <div class="input_group">
                                                <div class="mb-3">
                                                    <label>Cover Image (max size 500kb - 250x250)</label>
                                                    <div class="row">
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                                            <div class="me-3">
                                                                <label class="img_upload" for="large_file"><i class="fa fa-plus mx-1"></i> Upload</label>
                                                                <input type="file"  style="display: none;" id="large_file" class="cover-item-img"  >
                                                            </div>
                                                            <div>
                                                                @if(isset($banner->large_img) && $banner->large_img != '' && $banner->large_img != null)
                                                                <img src="{{asset('uploads/daily_updates/'.$banner->large_img)}}" class="img-fluid preview_image" id="cover-item-img-output">
                                                                @else
                                                                <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="cover-item-img-output">
                                                                @endif
                                                            </div>
                                                            <input type="hidden" name="cover_image" value="" id="cover_image_new">
                                                            <input type="hidden" name="cover_old_img" value="{{ isset($banner->large_img) ? $banner->large_img : ''}}" id="cover_old_img"> 
                                                        </div>
                                                    </div>
                                                    <span id="error-message" style="display: none;" class="parsley-errors-list">Please Upload Cover Image</span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Title</label>
                                                    <input class="form-control" id="title" name="title" type="text" required
                                                        data-parsley-required-message="Please Enter Title"
                                                        placeholder="Title">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Insert Link</label>
                                                    <input class="form-control" id="link" name="link" type="url"
                                                        placeholder="Insert Link" required
                                                        data-parsley-required-message="Please Enter Link">
                                                </div>
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-lg btn-primary">Save</button>
                                                    <button type="button" id="clear" name="clear"
                                                        class="btn btn-lg btn-danger">Clear</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <!-- <strong>Category List</strong> -->
                                <h5>Logo Slider List</h5>
                                </div>
                                <div class="card-body card-block px-0 py-3">
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Cover Image</th>
                                                    <th scope="col">Title</th>
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
<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Crop Image</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>
            <div class="modal-body">
                <div id="upload-demo" class="center-block"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
            </div>
        </div>
    </div>
</div>


    @endsection
    @section('script')
    <script>
// large image
    var $uploadCrop,
    tempFilename,
    rawImg,
    imageId;
    function readFile_large(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
                if (file.size > 500 * 1024) {
                // Display a toaster alert
                toastr.error('Image size must be less than 500kb');
                // Clear the file input
                $('.cover-item-img').val('');
                return;
            }
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                rawImg = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            console.log("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 250,
            height: 250,
            type: 'rectangle'
        },
        enforceBoundary: false,
        enableExif: true
    });
    $('#cropImagePop').on('shown.bs.modal', function(){
        $('.cr-slider-wrap').prepend('<p>Image Zoom</p>');
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function(){
            console.log('jQuery bind complete');
        });
    });

    $('#cropImagePop').on('hidden.bs.modal', function(){
        $('.cover-item-img').val('');
        $('.cr-slider-wrap p').remove();
    });

    $('.cover-item-img').on('change', function () { 
        readFile_large(this); 
    });
    
    $('#cropImageBtn').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
                // format: 'jpeg',
                backgroundColor : "#000000",
                format: 'png',
                size: {width: 250, height: 250}
            }).then(function (resp) {
                $('#cover-item-img-output').attr('src', resp);

                $('#cropImagePop').modal('hide');
                $('.cover-item-img').val('');
                $('#cover_image_new').val(resp);
                $('#cover_old_img').val('');
                $('#error-message').hide();
            });
        });
    </script>
    <script>
    $(document).ready(function() {
        var token = $("meta[name='csrf-token']").attr("content");

        var table = $('#myTable').DataTable({
            language: {
                search: "",
                "searchPlaceholder": "Search",
                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>',
                paginate: {
                    next: '&gt;', // or '→'
                    previous: '&lt;' // or '←' 
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
                    data: 'title',
                    name: 'title'
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
    const dummy = "{{asset('assets/images/user/img-demo_1041.jpg')}}";

    $(document).on("click", ".edit", function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        $.ajax({
            url: admin_url + "edit-logo-sliders",
            type: "post",
            data: {
                _token: token,
                id: id,
            },
            success: function(response) {
                if(response.status == 'success')
                {
                    var data = response.data;
                    $("#logo_id").val(data.id);
                    $("#title").val(data.title);
                    $("#link").val(data.link);
                    $("#cover_old_img").val(data.cover_image);
                    $("#cover-item-img-output").attr('src', data.img_url);
                    $("#modalCenterTitle").html("Edit Logo Slider");
                }else{
                    toastr.error(response.message);
                }
                // $("#slug").prop("readonly", true);
            },
        });
    });
    $(document).on("click", "#clear", function() {
        $("#logo_id").val("");
        $("#title").val("");
        $("#slug").val("");
        $("#link").val("");
        $("#cover_old_img").val("");
        $("#cover-item-img-output").attr('src', dummy);
        $("#modalCenterTitle").html("Add New Logo Slider");

    })

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