@extends('layouts.backend.index')
@section('main_content')
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="javascript:;"> Page Settings </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> About Us Page</a></li>
                </ul>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- [ Main Content ] start -->
                                <form action="{{ route('pagesetting.about_save') }}" method="POST" data-parsley-validate=""
                                    enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                            <div class="Recent-Users">
                                <h5>About Us Page</h5>

                                <div class="card-block px-0 py-3">
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <input type="hidden" name="setting_id"
                                                        value="{{ isset($about->id) ? $about->id : '' }}" class="form-control">
                                                    <label for="">Description </label><span style="color: red;margin: 0;">*
                                                    <span style="color: red;margin: 0;">*Maximum 5000 Characters</span>
                                                    <textarea id="summernote" name="description" required data-parsley-required-message="Please Enter Description" data-parsley-errors-container="#error_message">{{ isset($about->description) ? $about->description: '' }}</textarea>
                                                    <p id="error_message"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">YouTube Video Link 1</label>
                                                    <input type="url" class="form-control" placeholder="Enter YouTube Video Link 1" name="youtube_video" value="{{ isset($about->youtube_url) ? $about->youtube_url: '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">YouTube Video Link 2</label>
                                                    <input type="url" class="form-control" placeholder="Enter YouTube Video Link 2" name="youtube_video2" value="{{ isset($about->youtube_url_2) ? $about->youtube_url_2: '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Image (Prefer Square Image) </label>
                                                    <span style="color: red;margin: 0;">*Recommended Size: Upto 5MB.</span>
                                                    <div class="d-flex align-items-center">
                                                    <div class="input_group me-3">
                                                        <label class="img_upload" for="large_file"><i class="fa fa-plus mx-1"></i> Upload</label>
                                                        <input type="file" name="image" style="display: none;" id="large_file" class="cover-item-img" @if(isset($about->image))  @else required @endif data-parsley-required-message="Please Upload Image">
                                                    </div>
                                                <div class="preview_image">
                                                    @if(isset($about->image) && $about->image != '' && $about->image != null)
                                                    <img src="{{asset('uploads/'.$about->image)}}" class="img-fluid preview_image" id="cover-item-img-output">
                                                    @else
                                                    <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="cover-item-img-output">
                                                    @endif
                                                </div>
                                            </div>
                                                <input type="hidden" name="old_image" value="{{ isset($about->image) ? $about->image : '' }}" id="cover_old_img"> 
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Title </label>
                                                    <span style="color: red;margin: 0;">*Maximum 150 character.</span>
                                                    <input type="text" class="form-control" placeholder="Enter Title" name="title" required data-parsley-maxlength="150" value="{{ isset($about->title) ? $about->title: '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                        <div class="row form-sec mt-4">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <button type="submit" id="submit_form" class="common-sub-btn">Save</button>
                                            </div>

                                    </div>
                                </div>  
                            </div>
                        </div>
                </form>
                    <!-- [ Main Content ] end -->
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
    $('textarea#summernote').summernote({
        placeholder: 'Content',
        tabsize: 2,
        height: 300,
        toolbar: [
                ['font', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol']],
              ],
      });
</script>
<script>
    // Logo
    $('#large_file').change(function (e) {
            var input = e.target;
            var file = input.files[0];
            if (file) {               
                if (file.size <= 5 * 1024 * 1024) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#cover-item-img-output').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    toastr.error('File size should be less than or equal to 5 MB');
                    $('#large_file').val('');
                    $('#cover-item-img-output').attr('src', '{{ asset('assets/images/user/img-demo_1041.jpg') }}');
                }
            }
        });
   
</script>
@endsection
