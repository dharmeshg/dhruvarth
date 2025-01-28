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
                        <li class="breadcum-item active"><a href="javascript:;"> {{ isset($title) ? $title : '' }}</a></li>
                    </ul>
                </div>

                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page_header mb-3">
                            <h5>{{ isset($title) ? $title : '' }}</h5>
                            <a href="{{route('media.index')}}" class="back-btn">Back to Media</a>
                        </div>
                        <!-- [ Main Content ] start -->
                        <div id="all_sec_row">
                            <div id="show_all_sec" class="">
                        <div class="row">
                                <!--[ Recent Users ] start-->
                               @if(isset($sections) && count($sections) > 0)
                                    @foreach($sections as $section)
                                        <div class="col-md-12 col-xl-3 media_section_add_box edit_boxes">
                                            <div class="hover_div">
                                                <span class="edit_sec" data-id="{{ $section->id }}" style="margin-right: 8px;" title="Click here to Edit {{ isset($section->title) ? $section->title : '' }}">
                                                    <img src="{{asset('images/dashbord/create.png')}}" class="image-fuild" alt="user-img">
                                                </span>
                                                <span class="delete_sec" data-id="{{ $section->id }}">
                                                    <img src="{{asset('images/dashbord/delete.png')}}" class="image-fuild" alt="user-img" title="Click here to Delete {{ isset($section->title) ? $section->title : '' }}">
                                                </span>
                                            </div>
                                            @php 
                                            if($sec == 'ads-poster')
                                            {
                                                $route = route('adsposter.index', ['slug' => $section->slug]);
                                            }
                                            if($sec == 'logo-slider')
                                            {
                                                $route = route('logoslider.index', ['slug' => $section->slug]);
                                            }
                                            if($sec == 'pdf-list')
                                            {
                                                $route = route('pdflist.index', ['slug' => $section->slug]);
                                            }
                                            if($sec == 'page-banner')
                                            {
                                                $route = route('pagebanner.index', ['slug' => $section->slug]);
                                            }
                                            @endphp
                                            <a class="edit_boxes_inner" href="{{ isset($route) ? $route : ''}}">
                                                <div class="card card-social">
                                                    <div class="each_box">
                                                        <div class="row">
                                                            
                                                            <div class="col text-center mb-3 top_sec">
                                                                @if(isset($section->image) && $section->image != '' && $section->image != null)
                                                                    <img src="{{asset('uploads/media/'.$section->image)}}" alt="section-image">
                                                                @else
                                                                    <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" alt="default-image">
                                                                @endif
                                                            </div>
                                                            <h5 class="mb-3 dashboard_heading text-center">
                                                                <span class="heading_class">
                                                                    @php
                                                                    if (isset($section->title)) {
                                                                        $title = $section->title;
                                                                        if (strlen($title) > 23) {
                                                                            echo substr($title, 0, 23) . '...';
                                                                        } else {
                                                                            echo $title;
                                                                        }
                                                                    }
                                                                    @endphp
                                                                </span>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
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
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Add Section</span></h5>
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

@php
if(isset($title) && $title != '' && $title == 'Ads Poster Sections'){
 $section_name = "Please enter Title For Poster Section";
 $icon = "Please Upload Icon Image For Poster Section";
}
elseif(isset($title) && $title != '' && $title == 'Logo Slider Sections'){
$section_name = "Please enter Title For Logo Slider Section";
 $icon = "Please Upload Icon Image For Logo Slider Section";


}elseif(isset($title) && $title != '' && $title == 'PDF Sections'){
$section_name = "Please enter Title For PDF List Section";
 $icon = "Please Upload Icon Image For PDF List Section";

}elseif(isset($title) && $title != '' && $title == 'Page Banner'){
$section_name = "Please enter Title for Page Banner";

}
@endphp

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
            <input type="hidden" id="sec_id" name="sec_id">
            <input type="hidden" id="type" name="type" value="{{ isset($sec) ? $sec : '' }}">
            <div class="input_group">
                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlTextarea1">Title <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="{{isset($section_name ) ? $section_name  : ''}}"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                    <input class="form-control" id="title" name="title" type="text" required="" data-parsley-required-message="Please Enter Title" placeholder="Enter Title">
                </div>
                <div class="mb-3 input_group">
                    <label class="form-label" for="exampleFormControlTextarea1">Icon <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="{{isset($icon) ? $icon : ''}}"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label><span style="color: red;margin: 0;">*Recommended Size: 400x400 pixel upto 500KB.</span>
                    <div class="row">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                            <div class="me-3">
                                <label class="img_upload" for="large_file"><i class="fa fa-plus mx-1" aria-hidden="true"></i> Upload</label>
                                <input type="file" style="display: none;" name="sec_image" id="large_file" class="large-item-img">
                            </div>
                            <div class="image-sec">
                                <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" class="img-fluid preview_image" id="large-item-img-output">
                                <a class="show_close_icon" ><span class="remove_icons" style="font-size: 20px !important;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
                                <input type="hidden" name="sec_old_img" value="" id="large_old_img">
                            </div>
                            
                        </div>
                    </div>
                    <span id="error-message"></span>
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
        $('#sec_id').val('');
        $('#type').val('{{ isset($sec) ? $sec : '' }}');
        $('#large_old_img').val('');
        $('#large-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
        $('#section_add_modal').modal('show');
        $('.show_close_icon').css('display', 'none');

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
            $('.show_close_icon').css('display','block');
            // Display the selected image
            $('#large-item-img-output').attr('src', e.target.result);
            $('#error-message').hide();
        };

        reader.readAsDataURL(input.files[0]);
    }
});
$("#save_sec").click(function(){
        var isValid = $('#add_metal_rate').parsley().validate();
            if (isValid) {
            var formData = new FormData($('#add_metal_rate')[0]);
            $.ajax({
            url: '{{route('media.section.store')}}', 
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
       }

    });
$(document).on("click",".edit_sec",function() {
    var id = $(this).data('id');
    $.ajax({
            url: '{{route('media.section.get')}}', 
            type: 'POST',
            data: {id:id},
            success: function (response) {
                if(response.status == 1)
                {
                    $('.modal-title').text('Edit Section');
                    $('#title').val(response.data.title);
                    $('#sec_id').val(response.data.id);
                    $('#type').val(response.data.type);
                    $('#large_old_img').val(response.data.image);
                    $('#large-item-img-output').attr('src', response.data.url);
                    var img_url = '{{ asset('assets/images/user/img-demo_1041.jpg') }}';
                    // if (response.data.url != 'https://jewelxy.workdemo.in.net/assets/images/user/img-demo_1041.jpg') {
                    if (response.data.url != img_url) {

                        console.log(img_url);
                        $('.show_close_icon').css('display','block');
                    }else{
                        console.log("check");
                        $('.show_close_icon').css('display','none');
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
                    url: '{{route('media.section.delete')}}', 
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
        // $('#old_img').val('');
        $this.hide();
    });
</script>
@endsection
