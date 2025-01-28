@extends('layouts.backend.index')
@section('main_content')
<style>
    .each-about-sec{padding: 15px;color: #000;border: 1px solid #eee;border-radius: 5px;position: relative;}
    .add-more-sec span{position: absolute;text-align: end;font-size: 30px !important;color: #000;top: -12px;right: -6px;cursor: pointer;}
</style>
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                     <li class="breadcum-item"><a href="{{route('setting_all.index')}}">Settings</a></li>
                    <li class="breadcum-item"><a href="javascript:;"> Page Settings </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> About Us</a></li>
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
                                    @if(isset($data) && count($data) > 0)
                                    @foreach($data as $key => $val)
                                    <div class="each-about-sec @if(isset($key) && $key != 0) mt-4 @endif">
                                        <a class="add-more-sec @if(isset($key) && $key != 0) remove-sec @else add-sec @endif">
                                            <span>
                                                @if(isset($key) && $key != 0)
                                                <i class="fa fa-times-circle"></i>
                                                @else
                                                <!-- <i class='fas fa-plus-circle'></i> -->
                                                @endif
                                            </span>
                                        </a>
                                    <div class="row">
                                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                <label for="">Title <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert title for About Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                <span style="color: red;margin: 0;">*Maximum 150 character.</span>
                                                <input type="text" class="form-control" placeholder="Enter Title" name="title[]" required data-parsley-maxlength="150" value="{{ isset($val->title) ? $val->title: '' }}">
                                            </div>
                                            <div class="form-sec">
                                                    <label for="">Description <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Description For About Us Page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <span style="color: red;margin: 0;">*Maximum 5000 Characters</span>
                                                    <textarea id="summernote" name="description[]"  placeholder="Enter Description" required data-parsley-required-message="Please Enter Description" data-parsley-errors-container="#error_message">{{ isset($val->description) ? $val->description: '' }}</textarea>
                                                    <p id="error_message"></p>
                                            </div>
                                            
                                        </div>
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-sec image-sec">
                                                    <label for="">Image (Prefer Square Image) <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload the image for About Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <span style="color: red;margin: 0;">*Recommended Size: Upto 5MB. </span>
                                                    <div class="d-flex align-items-center">
                                                    <div class="input_group me-3">
                                                        <label class="img_upload" for="large_file_{{$key}}"><i class="fa fa-plus mx-1"></i> Upload</label>
                                                        <input type="file" name="image[]" style="display: none;" id="large_file_{{$key}}" class="cover-item-img">
                                                    </div>
                                                <div class="preview_image">
                                                    @if(isset($val->image) && $val->image != '' && $val->image != null)
                                                    <div  style="position: relative;">
                                                        <img src="{{asset('uploads/images/'.$val->image)}}" class="img-fluid img-view" id="cover-item-img-output">
                                                        <a class="show_close_icon" ><span class="remove_icons" style="right: -94px !important;font-size: 20px !important;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
                                                    </div>
                                                    @else
                                                    <div  style="position: relative;">
                                                        <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid img-view" id="cover-item-img-output">
                                                        <a class="show_close_icon" style="display: none;"><span class="remove_icons" style="right: -94px !important;font-size: 20px !important;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                                <input type="hidden" name="old_image[]" value="{{ isset($val->image) ? $val->image : '' }}" id="cover_old_img" class="cover_old_img"> 
                                            </div>
                                            <div class="form-sec">
                                            <label for="">YouTube Video Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter YouTube Video Link For About Us Page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label><span style="color: red;margin: 0;">*Embeded youtube link only</span>
                                                    <input type="url" class="form-control" placeholder="Enter YouTube Video Link " name="youtube_video[]" value="{{ isset($val->youtube_video) ? $val->youtube_video: '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <a class="add-more-sec  add-sec"><span><i class='fas fa-plus-circle'></i></span></a> -->

                                    @endforeach
                                    @else
                                    <div class="each-about-sec">
                                        <a class="add-more-sec add-sec">
                                            <span>
                                                <i class='fas fa-plus-circle'></i>
                                            </span>
                                        </a>
                                    <div class="row">
                                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                <label for="">Title <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert title for About Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                <span style="color: red;margin: 0;">*Maximum 150 character.</span>
                                                <input type="text" class="form-control" placeholder="Enter Title" name="title[]" required data-parsley-maxlength="150">
                                            </div>
                                            <div class="form-sec">
                                                    <input type="hidden" name="setting_id"
                                                        value="{{ isset($about->id) ? $about->id : '' }}" class="form-control">
                                                    <label for="">Description <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert description for About Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <span style="color: red;margin: 0;">*Maximum 5000 Characters</span>
                                                    <textarea id="summernote" name="description[]"  placeholder="Enter Description" required data-parsley-required-message="Please Enter Description" data-parsley-errors-container="#error_message"></textarea>
                                                    <p id="error_message"></p>
                                            </div>
                                            
                                        </div>
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Image (Prefer Square Image) <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload the image for About Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <span style="color: red;margin: 0;">*Recommended Size: Upto 5MB. </span>
                                                    <div class="d-flex align-items-center">
                                                    <div class="input_group me-3">
                                                        <label class="img_upload" for="large_file"><i class="fa fa-plus mx-1"></i> Upload</label>
                                                        <input type="file" name="image[]" style="display: none;" id="large_file" class="cover-item-img">
                                                    </div>
                                                <div class="preview_image">
                                                    <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid img-view" id="cover-item-img-output">
                                                    
                                                </div>
                                            </div>
                                            </div>
                                            <div class="form-sec">
                                            <label for="">YouTube Video Link 2 <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert YouTube link 2 for About Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label><span style="color: red;margin: 0;">*Embeded youtube link only</span>
                                                    <input type="url" class="form-control" placeholder="Enter YouTube Video Link 2" name="youtube_video[]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div id="more-sec">
                                    <input type="hidden" value="{{ isset($data) ? count($data) : 0 }}" id="buy_count">
                                </div>
                                    </div>
                                     <div class="row form-sec mt-4">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec"><hr>
                                               <!-- <a class="add-more-sec  add-sec"><span><i class='fas fa-plus-circle'></i></span></a> -->
                                               <a type="button" class="add-more-sec add-sec about_us-field-add-more-btn"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a>
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
        placeholder: 'Enter Description',
        tabsize: 2,
        height: 150,
        toolbar: [
                ['font', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol']],
              ],
      });
</script>

<script>
   var existing_counter = $('#buy_count').val()
    if(existing_counter && existing_counter != '')
    {
        var counter = parseInt(existing_counter) + 1;
    }else{
        var counter = 1;
    }
     $(document).on("click",".add-sec",function() {
        var html = '<div class="each-about-sec mt-4"><a class="remove-sec add-more-sec"><span><i class="fa fa-times-circle"></i></span></a><div class="row"><div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12"><div class="form-sec"><label for="">Title<span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert title for About Us page"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label><span style="color:red;margin:0">*Maximum 150 character.</span><input type="text" class="form-control" placeholder="Enter Title" name="title[]" data-parsley-maxlength="150" value=""></div><div class="form-sec"><label for="">Description<span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert description for About Us page"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label><span style="color:red;margin:0">*Maximum 5000 Characters</span><textarea name="description[]" placeholder="Enter Description" required data-parsley-required-message="Please Enter Description" data-parsley-errors-container="#error_message" class="summernote"></textarea><p id="error_message"></p></div></div><div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12"><div class="form-sec"><label for="">Image (Prefer Square Image)<span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload the image for About Us page"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label><span style="color:red;margin:0">*Recommended Size: Upto 5MB.</span><div class="d-flex align-items-center"><div class="input_group me-3"><label class="img_upload" for="large_file_'+ counter +'"><i class="fa fa-plus mx-1"></i>Upload</label><input type="file" name="image[]" style="display:none" class="cover-item-img" id="large_file_'+ counter +'"></div><div class="preview_image"><img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid img-view" id="cover-item-img-output"></div></div></div><div class="form-sec"><label for="">YouTube Video Link<span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert YouTube link for About Us page"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label><input type="url" class="form-control" placeholder="Enter YouTube Video Link" name="youtube_video[]" value=""></div></div></div></div>';
        $('#more-sec').append(html);
        counter++;
        $('textarea.summernote').summernote({
        placeholder: 'Enter Description',
        tabsize: 2,
        height: 150,
        toolbar: [
                ['font', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol']],
              ],
      });
     });
      
     $(document).on("click", ".show_close_icon", function() { 
        var $this = $(this);
        $this.closest('.image-sec').find('.cover_old_img').val(''); 
        $this.closest('.image-sec').find('.img-view').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}'); 
        // $('#old_img').val('');
        $this.hide();
    });
   

     $(document).on("click",".remove-sec",function() {
        $(this).closest('.each-about-sec').remove();
     });
     $(document).on("change", ".cover-item-img", function (e) {
        var input = e.target;
        var $this = $(this);
        var file = input.files[0]; // Assuming only one file is selected

        // Check if the file is an image
        if (/^image\//.test(file.type)) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(input).closest('.each-about-sec').find('.img-view').attr('src', e.target.result);
            };
            $this.closest('.image-sec').find('.show_close_icon').show(); 

            reader.readAsDataURL(file);
        } else {
            toastr.error('Please select a valid image file.');
            $(input).val(''); // Clear the input field
            // You may want to set a default image here as well
            $(input).next().attr('src', '{{ asset('assets/images/user/img-demo_1041.jpg') }}');
            $this.closest('.image-sec').find('.show_close_icon').hide(); 
        }
    });
</script>
@endsection
