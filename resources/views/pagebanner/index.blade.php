@extends('layouts.backend.index')
@section('main_content')
<div class="pcoded-wrapper">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <div class="custom_breadcum">
                    <ul>
                        <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcum-item"><a href="{{route('media.index')}}"> Media </a></li>
                        <li class="breadcum-item active"><a href="javascript:;"> Page Banner</a></li>
                    </ul>
                </div>

                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page_header mb-3">
                            <h5>Page Banner</h5>
                            <a href="{{route('media.index')}}" class="back-btn">Back to Media</a>
                        </div>
                        <!-- [ Main Content ] start -->
                        <div id="all_sec_row">
                            <div id="show_all_sec" class="">
                        <div class="row">
                                <!--[ Recent Users ] start-->
                               @if(isset($page_banners) && count($page_banners) > 0)
                                    @foreach($page_banners as $page_banner)
                                        <div class="col-md-12 col-xl-3 media_section_add_box edit_boxes">
                                            <div class="hover_div">
                                                <span class="edit_sec" data-id="{{ $page_banner->id }}" style="margin-right: 8px;" title="Click here to Edit Page Banner">
                                                    <img src="{{asset('images/dashbord/create.png')}}" class="image-fuild" alt="user-img">
                                                </span>
                                                <span class="delete_sec" data-id="{{ $page_banner->id }}" title="Click here to Delete Page Banner">
                                                    <img src="{{asset('images/dashbord/delete.png')}}" class="image-fuild" alt="user-img">
                                                </span>
                                            </div>
                                                <div class="card card-social">
                                                    <div class="each_box">
                                                        <div class="row">
                                                            
                                                            <div class="col text-center mb-3 top_sec">
                                                                @if(isset($page_banner->cover_image) && $page_banner->cover_image != '' && $page_banner->cover_image != null)
                                                                    <img src="{{asset('uploads/media/'.$page_banner->cover_image)}}" alt="section-image">
                                                                @else
                                                                    <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" alt="default-image">
                                                                @endif
                                                            </div>
                                                            <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">{{ isset($page_banner->title) ? $page_banner->title : '' }}</span></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    @endforeach
                                @endif

        

                                <div class="col-md-12 col-xl-3 media_section_add_box">
                                    <a href="javascript:;" id="add_section">
                                        <div class="card card-social">
                                            <div class="each_box">
                                                <div class="row">
                                                    <div class="col text-center mb-3 top_sec">
                                                        <span><img src="{{asset('assets/images/pluse.svg')}}" class="img-fluid add_sec"></span>
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Add Page Banner</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- [ Main Content ] end -->
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

<div class="modal" tabindex="-1" id="section_add_modal">
  <div class="modal-dialog">
    <div class="modal-content">
        <form id="add_metal_rate" method="post" data-parsley-validate="" enctype="multipart/form-data">
            @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add Section</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">        
            <input type="hidden" id="p_banner_id" name="p_banner_id">
            <div class="input_group">
                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlTextarea1">Title <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Title for Page Banner"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                    <input class="form-control" id="title" name="title" type="text" required="" data-parsley-required-message="Please Enter Title" placeholder="Enter Title">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlTextarea1">Url's (Add multiple url using comma seprate) <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter URL for Page Banner"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                    <input class="form-control" id="url" name="url" type="text" required="" data-parsley-required-message="Please Enter Url" placeholder="Enter Url">
                </div>
                <div class="mb-3 input_group image-load">
                    <label class="form-label" for="exampleFormControlTextarea1">Large Banner <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload banner for section"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label><span style="color: red;margin: 0;">*Recommended Size: 1920x300 pixel upto 500KB.</span>
                    <div class="row ">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                            <div class="me-3 page_banner_img">
                                <label class="img_upload" for="large_file"><i class="fa fa-plus mx-1" aria-hidden="true"></i> Upload</label>
                                <input type="file" style="display: none;" name="sec_image" id="large_file" class="large-item-img" required data-parsley-errors-container="#error-message" data-parsley-required-message="Please Upload Banner Image">
                            </div>
                           
                            <div class="image-sec">
                                <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" class="img-fluid preview_image" id="large-item-img-output">
                                <a class="show_close_icon" style="display: none;"><span class="remove_icons" style="font-size: 20px !important;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
                                <input type="hidden" name="sec_old_img" value="" id="large_old_img">
                            </div>
                            
                        </div>
                    </div>
                    <span id="error-message"></span>
                </div>

                <div class="mb-3 input_group image-load">
                    <label class="form-label" for="exampleFormControlTextarea1">Medium Banner <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload banner for section"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label><span style="color: red;margin: 0;">*Recommended Size: 750x200 pixel upto 500KB.</span>
                    <div class="row ">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                            <div class="me-3 page_banner_img">
                                <label class="img_upload" for="medium_file"><i class="fa fa-plus mx-1" aria-hidden="true"></i> Upload</label>
                                <input type="file" style="display: none;" name="sec_med_image" id="medium_file" class="medium-item-img" required data-parsley-errors-container="#error-message" data-parsley-required-message="Please Upload Medium Banner Image">
                            </div>
                           
                            <div class="image-sec">
                                <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" class="img-fluid preview_image" id="medium-item-img-output">
                                <a class="med_show_close_icon" style="display: none;"><span class="remove_icons" style="font-size: 20px !important;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
                                <input type="hidden" name="sec_med_old_img" value="" id="medium_old_img" required data-parsley-errors-container="#error-message" data-parsley-required-message="Please Upload Medium Banner Image">
                            </div>
                            
                        </div>
                    </div>
                    <span id="med-error-message"></span>
                </div>

                <div class="mb-3 input_group image-load">
                    <label class="form-label" for="exampleFormControlTextarea1">Small Banner <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload banner for section"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label><span style="color: red;margin: 0;">*Recommended Size: 500x170 pixel upto 500KB.</span>
                    <div class="row ">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                            <div class="me-3 page_banner_img">
                                <label class="img_upload" for="small_file"><i class="fa fa-plus mx-1" aria-hidden="true"></i> Upload</label>
                                <input type="file" style="display: none;" name="sec_small_image" id="small_file" class="small-item-img">
                            </div>
                           
                            <div class="image-sec">
                                <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" class="img-fluid preview_image" id="small-item-img-output">
                                <a class="small_show_close_icon" style="display: none;"><span class="remove_icons" style="font-size: 20px !important;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
                                <input type="hidden" name="sec_small_old_img" value="" id="small_old_img" required data-parsley-errors-container="#error-message" data-parsley-required-message="Please Upload Small Banner Image">
                            </div>
                            
                        </div>
                    </div>
                    <span id="small-error-message"></span>
                </div>
                
            </div>
        
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_sec">Save</button>
    </div>
    </form>
</div>
</div>
</div>
@endsection
@section('script')
<script>
    $(document).on("click","#add_section",function() {
        $('#add_metal_rate').parsley().reset();
        $('#add_metal_rate')[0].reset();
        $('.modal-title').text('Add Section');
        $('#title').val('');
        $('#p_banner_id').val('');
        $('#large_old_img').val('');
        $('#large-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
        $('#medium_old_img').val('');
        $('#medium-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
        $('#small_old_img').val('');
        $('#small-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
        $('#section_add_modal').modal('show');
    });
   $('.large-item-img').on('change', function () { 
    var input = this;

    if (input.files && input.files[0]) {
        // Check if the file type is an image
        if (!input.files[0].type.startsWith('image/')) {
            $('#error-message').text('Please select a valid image file.');
            $('#error-message').show();
            $('.large-item-img').val('');
            $('#large-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
            return;
        }

        var reader = new FileReader();

        reader.onload = function (e) {
            // Display the selected image
            $('#large-item-img-output').attr('src', e.target.result);
            $('.show_close_icon').css('display','block');
            $('#error-message').hide();
        };

        reader.readAsDataURL(input.files[0]);
    }
});

   $('.medium-item-img').on('change', function () { 
    var input = this;

    if (input.files && input.files[0]) {
        // Check if the file type is an image
        if (!input.files[0].type.startsWith('image/')) {
            $('#med-error-message').text('Please select a valid image file.');
            $('#med-error-message').show();
            $('.medium-item-img').val('');
            $('#medium-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
            return;
        }

        var reader = new FileReader();

        reader.onload = function (e) {
            // Display the selected image
            $('#medium-item-img-output').attr('src', e.target.result);
            $('.med_show_close_icon').css('display','block');
            $('#med-error-message').hide();
        };

        reader.readAsDataURL(input.files[0]);
    }
});

   $('.small-item-img').on('change', function () { 
    var input = this;

    if (input.files && input.files[0]) {
        // Check if the file type is an image
        if (!input.files[0].type.startsWith('image/')) {
            $('#small-error-message').text('Please select a valid image file.');
            $('#small-error-message').show();
            $('.small-item-img').val('');
            $('#small-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
            return;
        }

        var reader = new FileReader();

        reader.onload = function (e) {
            // Display the selected image
            $('#small-item-img-output').attr('src', e.target.result);
            $('.small_show_close_icon').css('display','block');
            $('#small-error-message').hide();
        };

        reader.readAsDataURL(input.files[0]);
    }
});
$("#save_sec").click(function(){
        var isValid = $('#add_metal_rate').parsley().validate();
            if (isValid) {
            var formData = new FormData($('#add_metal_rate')[0]);
      
            $.ajax({
            url: '{{route('pagebanner.save')}}', 
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if(response.status == 1)
                {
                    $('#add_metal_rate')[0].reset();
                    $('#section_add_modal').modal('hide');
                    toastr.success(response.message);
                    $('#all_sec_row').load(' #show_all_sec');
                }else{
                    toastr.error('Something Went Wrong!');
                }
            },
            error: function (error) {
                // Handle error response from the server
                console.error(error);
            }
        });
       }else
       {
        // toaster.error('Validation Error');
        return;
       }

    });
$(document).on("click",".edit_sec",function() {
    var id = $(this).data('id');
    $.ajax({
            url: '{{route('pagebanner.edit')}}', 
            type: 'POST',
            data: {id:id},
            success: function (response) {
                if(response.status == 1)
                {
                    $('.modal-title').text('Edit Banner');
                    $('#title').val(response.data.title);
                    $('#url').val(response.data.url);
                    $('#p_banner_id').val(response.data.id);
                    $('#large_old_img').val(response.data.cover_image);
                    $('#large-item-img-output').attr('src', response.data.img_url);
                    $('#medium_old_img').val(response.data.medium_image);
                    $('#medium-item-img-output').attr('src', response.data.med_img_url);
                    $('#small_old_img').val(response.data.small_image);
                    $('#small-item-img-output').attr('src', response.data.small_img_url);

                    if(response.data.img_url && response.data.img_url != null && response.data.img_url != '')
                    {
                        $('#large_file').attr('required', false);
                        $('.show_close_icon').css('display', 'block');
                    }else{
                        $('#large_file').attr('required', true);
                        $('#large-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
                    }

                    if(response.data.med_img_url && response.data.med_img_url != null && response.data.med_img_url != '')
                    {
                        $('#medium_file').attr('required', false);
                        $('.med_show_close_icon').css('display', 'block');
                    }else{
                        $('#medium_file').attr('required', true);
                        $('#medium-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
                    }

                    if(response.data.small_img_url && response.data.small_img_url != null && response.data.small_img_url != '')
                    {
                        $('#small_file').attr('required', false);
                        $('.small_show_close_icon').css('display', 'block');
                    }else{
                        $('#small_file').attr('required', true);
                        $('#small-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
                    }

                    $('#section_add_modal').modal('show');
                }else{
                    toastr.error('Something Went Wrong!');
                }
            },
            error: function (error) {
            }
        });
});
$(document).on("click",".delete_sec",function() {
    var id = $(this).data('id');
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
                 $.ajax({
                    url: '{{route('pagebanner.delete')}}', 
                    type: 'POST',
                    data: {id:id},
                    success: function (response) {
                        if(response.status == 1)
                        {
                            toastr.error(response.message);
                            $('#all_sec_row').load(' #show_all_sec');
                        }else{
                            toastr.error('Something Went Wrong!');
                        }
                    },
                    error: function (error) {
                    }
                });
            }
        });
});

   $(document).on("click", ".show_close_icon", function() { 
        var $this = $(this);
        $this.closest('.image-sec').find('#large_old_img').val(''); 
        $this.closest('.image-sec').find('#large-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}'); 
        $('#add_metal_rate #large_file').val('');
        // $this.closest('#add_metal_rate').find('.large-item-img').val('');
        // $('#large_file').prop('required', true);
         $('#large_file').attr('required', true);
         $('.image-load #error-message').css('display', 'block');
        $this.hide();
    });

   $(document).on("click", ".med_show_close_icon", function() { 
        var $this = $(this);
        $this.closest('.image-sec').find('#medium_old_img').val(''); 
        $this.closest('.image-sec').find('#medium-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}'); 
        $('#add_metal_rate #medium_file').val('');         $('#medium_file').attr('required', true);
         $('.image-load #med-error-message').css('display', 'block');
        $this.hide();
    });

   $(document).on("click", ".small_show_close_icon", function() { 
        var $this = $(this);
        $this.closest('.image-sec').find('#small_old_img').val(''); 
        $this.closest('.image-sec').find('#small-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}'); 
        $('#add_metal_rate #small_file').val('');
         $('#small_file').attr('required', true);
         $('.image-load #small-error-message').css('display', 'block');
        $this.hide();
    });


</script>
@endsection
