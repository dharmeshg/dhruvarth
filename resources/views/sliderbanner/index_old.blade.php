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
                                    <h5 id="modalCenterTitle">Add New Slider Banner</h5>
                                </div>
                                <div class="card-body">
                                    <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                                        <form id="addcategory" action="{{ route('sliderbanner.save') }}" method="POST"
                                            data-parsley-validate="">
                                            @csrf
                                            <input type="hidden" id="banner_id" name="banner_id">
                                            <div class="input_group">
                                            <div class="mb-3">
                                <label>Large (1920x600)</label>
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                        <div class="me-3">
                                            <label class="img_upload" for="large_file"><i class="fa fa-plus mx-1"></i> Upload</label>
                                            <input type="file"  style="display: none;" id="large_file" class="large-item-img"  accept="image/*">
                                        </div>
                                        <div>
                                            <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="large-item-img-output">
                                        </div>
                                        <input type="hidden" name="large_image" value="" required data-parsley-required-message="Image is Required" id="large_image_new">
                                        <input type="hidden" name="large_old_img" value="" id="large_old_img">
                                    </div>
                                </div>
                                <span id="error-message" style="display: none;" class="parsley-errors-list">Please Upload Large Image</span>
                            </div>
                            <div class="mb-3">
                                <label>Medium (992x525)</label>
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                        <div class="me-3">
                                            <label class="img_upload" for="medium_image_file"><i class="fa fa-plus mx-1"></i> Upload</label>
                                            <input type="file"  style="display: none;" id="medium_image_file" class="medium-item-img"  accept="image/*">
                                        </div>
                                        <div>
                                            <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="medium-item-img-output">
                                        </div>
                                        <input type="hidden" name="medium_image" value="" required data-parsley-required-message="Image is Required" id="medium_image_new">
                                        <input type="hidden" name="medium_old_img" value="" id="old_img">
                                    </div>
                                </div>
                                <span id="error-message1" style="display: none;" class="parsley-errors-list">Please Upload Medium Image</span>
                            </div>
                            <div class="mb-3">
                                <label>Small (768x450)</label>
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                        <div class="me-3">
                                            <label class="img_upload" for="small_image_file"><i class="fa fa-plus mx-1"></i> Upload</label>
                                            <input type="file"  style="display: none;" id="small_image_file" class="small-item-img" accept="image/*" >
                                        </div>
                                        <div>
                                            <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="small-item-img-output">
                                        </div>
                                        <input type="hidden" name="small_image" value="" required data-parsley-required-message="Image is Required" id="samll_image_new">
                                        <input type="hidden" name="small_old_img" value="" id="small_old_img">
                                    </div>
                                </div>
                                <span id="error-message2" style="display: none;" class="parsley-errors-list">Please Upload Small Image</span>
                            </div>
                            <div class="mb-3">
                                        <label>Destination Link</label>
                                        <input type="url" name="destination_link" class="form-control" required data-parsley-required-message="Destination Link is Required" value="" id="link">
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
                                <h5>Slider Banner List</h5>
                                </div>
                                <div class="card-body card-block px-0 py-3">
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Large Image</th>
                                                    <th scope="col">Medium Image</th>
                                                    <th scope="col">Small Image</th>
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
<div class="modal fade" id="cropImagePop1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Crop Image</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        </div>
        <div class="modal-body">
            <div id="upload-demo1" class="center-block"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
            <button type="button" id="cropImageBtn1" class="btn btn-primary">Crop</button>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="cropImagePop2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Crop Image</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        </div>
        <div class="modal-body">
            <div id="upload-demo2" class="center-block"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
            <button type="button" id="cropImageBtn2" class="btn btn-primary">Crop</button>
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
                toastr.error('Image size must be less than 500kb');
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
            width: 160,
            height: 160,
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
        $('.large-item-img').val('');
        $('.cr-slider-wrap p').remove();
    });

    $('.large-item-img').on('change', function () { 
        readFile_large(this); 
    });
    
    $('#cropImageBtn').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
                // format: 'jpeg',
                backgroundColor : "#000000",
                format: 'png',
                size: {width: 160, height: 160}
            }).then(function (resp) {
                $('#large-item-img-output').attr('src', resp);

                $('#cropImagePop').modal('hide');
                $('.large-item-img').val('');
                $('#large_image_new').val(resp);
                $('#large_old_img').val('');
                $('#error-message').hide();
            });
        });
    </script>
    <script>
        // medimum
    var $uploadCropmedium,
    tempFilenamemedium,
    rawImgmedium,
    imageId;
    function readFile_medium(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
                if (file.size > 500 * 1024) {
                toastr.error('Image size must be less than 500kb');
                $('.cover-item-img').val('');
                return;
            }
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop1').modal('show');
                rawImgmedium = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            console.log("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCropmedium = $('#upload-demo1').croppie({
        viewport: {
            width: 160,
            height: 160,
            type: 'rectangle'
        },
        enforceBoundary: false,
        enableExif: true
    });
    $('#cropImagePop1').on('shown.bs.modal', function(){
        $('.cr-slider-wrap').prepend('<p>Image Zoom</p>');
        $uploadCropmedium.croppie('bind', {
            url: rawImgmedium
        }).then(function(){
            console.log('jQuery bind complete');
        });
    });

    $('#cropImagePop1').on('hidden.bs.modal', function(){
        $('.medium-item-img').val('');
        $('.cr-slider-wrap p').remove();
    });

    $('.medium-item-img').on('change', function () { 
        readFile_medium(this); 
    });
    
    $('#cropImageBtn1').on('click', function (ev) {
        $uploadCropmedium.croppie('result', {
            type: 'base64',
                // format: 'jpeg',
                backgroundColor : "#000000",
                format: 'png',
                size: {width: 160, height: 160}
            }).then(function (resp) {
                $('#medium-item-img-output').attr('src', resp);

                $('#cropImagePop1').modal('hide');
                $('.medium-item-img').val('');
                $('#medium_image_new').val(resp);
                $('#medium_old_img').val('');
                $('#error-message1').hide();
            });
        });
    </script>
    <script>
        // small
    var $uploadCropsmall,
    tempFilenamesmall,
    rawImgsmall,
    imageId;
    function readFile_small(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
                if (file.size > 500 * 1024) {
                toastr.error('Image size must be less than 500kb');
                $('.cover-item-img').val('');
                return;
            }
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop2').modal('show');
                rawImgsmall = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            console.log("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCropsmall = $('#upload-demo2').croppie({
        viewport: {
            width: 160,
            height: 160,
            type: 'rectangle'
        },
        enforceBoundary: false,
        enableExif: true
    });
    $('#cropImagePop2').on('shown.bs.modal', function(){
        $('.cr-slider-wrap').prepend('<p>Image Zoom</p>');
        $uploadCropsmall.croppie('bind', {
            url: rawImgsmall
        }).then(function(){
            console.log('jQuery bind complete');
        });
    });

    $('#cropImagePop2').on('hidden.bs.modal', function(){
        $('.small-item-img').val('');
        $('.cr-slider-wrap p').remove();
    });

    $('.small-item-img').on('change', function () { 
        readFile_small(this); 
    });
    
    $('#cropImageBtn2').on('click', function (ev) {
        $uploadCropsmall.croppie('result', {
            type: 'base64',
                // format: 'jpeg',
                backgroundColor : "#000000",
                format: 'png',
                size: {width: 160, height: 160}
            }).then(function (resp) {
                $('#small-item-img-output').attr('src', resp);

                $('#cropImagePop2').modal('hide');
                $('.small-item-img').val('');
                $('#samll_image_new').val(resp);
                $('#samll_old_img').val('');
                $('#error-message2').hide();
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
                url: admin_url + "list-slider-banner",
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
                    data: 'large_img',
                    name: 'large_img'
                },
                {
                    data: 'medium_img',
                    name: 'medium_img'
                },
                {
                    data: 'small_img',
                    name: 'small_img'
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
            text: 'You are about to delete the Slider Banner!',
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
            url: admin_url + "edit-slider-banner",
            type: "post",
            data: {
                _token: token,
                id: id,
            },
            success: function(response) {
                if(response.status == 'success')
                {
                    var data = response.data;
                    $("#banner_id").val(data.id);
                    $("#link").val(data.destination_link);
                    $("#large_old_img").val(data.large_img);
                    $("#large-item-img-output").attr('src', data.large_url);
                    $("#old_img").val(data.medium_img);
                    $("#medium-item-img-output").attr('src', data.medium_url);
                    $("#small_old_img").val(data.small_img);
                    $("#small-item-img-output").attr('src', data.small_url);
                    $("#modalCenterTitle").html("Edit Slider Banner");
                }else{
                    toastr.error(response.message);
                }
                // $("#slug").prop("readonly", true);
            },
        });
    });
    $(document).on("click", "#clear", function() {
        $("#banner_id").val("");
        $("#link").val("");
        $("#large_old_img").val("");
        $("#old_img").val("");
        $("#small_old_img").val("");
        $("#large-item-img-output").attr('src', dummy);
        $("#medium-item-img-output").attr('src', dummy);
        $("#small-item-img-output").attr('src', dummy);
        $("#modalCenterTitle").html("Add New Slider Banner");

    })

    $(document).on('click', '#is_featured', function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        var isChecked = $(this).is(':checked');
        $.ajax({
            url: admin_url + "status-slider-banner",
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
            if ($('#addcategory').parsley().isValid() && 
                (($('#large_old_img').val() != '' && $('#large_image_new').val() != '') || 
                 ($('#medium_old_img').val() != '' && $('#medium_image_new').val() != '') || 
                 ($('#small_old_img').val() != '' && $('#samll_image_new').val() != '') )) {
                    $('#addcategory').submit();
            } else {
                $('#error-message').show();
                $('#error-message1').show();
                $('#error-message2').show();
                e.preventDefault(); 
            }
        });
    </script>

    @endsection