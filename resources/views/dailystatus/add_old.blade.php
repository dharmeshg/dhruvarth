@extends('layouts.backend.index')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css'>
@section('main_content')
<style type="text/css">
.bootstrap-datetimepicker-widget td.disabled{
    color: #777 !important;
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
                    <form id="daily_status_add" action="{{ route('daliystatus.save') }}" enctype="multipart/form-data" method="POST" data-parsley-validate="">
                        @csrf
                        <div class="row">
                            <div
                            class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                            <div class="card Recent-Users">
                                @if (isset($data) && $data != '')
                                <h5>Edit Daily Status</h5>
                                @else
                                <h5>Add Daily Status</h5>
                                @endif
                                <div class="card-block px-0 py-3">
                                    <input type="hidden" name="status_id" value="{{ isset($data->id) ? $data->id : '' }}">

                                    <div class="row form-sec">
                                        <div
                                        class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                        <label>Destination Link</label>
                                    </div>
                                    <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                      <input type="url" name="destination_link" class="form-control" required data-parsley-required-message="Destination Link is Required" value="{{ isset($data->destination_link) ? $data->destination_link : '' }}">
                                  </div>
                              </div>

                              <div class="row form-sec">
                                <div
                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                <label>Notification Message</label>
                            </div>
                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                <textarea class="form-control" name="notification_message" rows="5">{{ isset($data->notification_message) ? $data->notification_message : '' }}</textarea>
                            </div>
                        </div>

                        <div class="row form-sec">
                            <div
                            class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec"></div>
                            <div
                            class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 label-sec">
                            <button type="submit" id="add_promo_code" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 cpl-sm-12 col-xs-12 add-article form-main-sec right-sec">
            <div class="card Recent-Users">
                <h5>Popup Image (square)</h5>
                <div class="card-block px-0 py-3">
                 <div class="row form-sec">

                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center input_group">
                        <div class="mt-4">
                             <label for="image_file" style="cursor: pointer;" class="form-label img_upload daily_status_image btn-primary">Choose image</label>
                            <input type="file"  style="display: none;" id="image_file" class="item-img">
                            <span id="error-message" style="display: none; color: red;" class="parsley-errors-list">Please Upload Image</span>
                        </div>
                    </div>
                   
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center">
                         <div>
                            @if(isset($data->image) && $data->image != '' && $data->image != null)
                            <img src="{{asset('uploads/daily_updates/'.$data->image)}}" class="img-fluid preview_image" id="item-img-output">
                            @else
                            <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="item-img-output">
                            @endif
                        </div>

                        <input type="hidden" name="image" value="" id="image_new" >
                        <input type="hidden" name="old_img" value="{{ isset($data->image) ? $data->image : ''}}" id="old_img">
                    </div>
                   
                        
                    </div>
                </div>
            </div>

        <div class="card Recent-Users next-box">
            <h5>Status</h5>
            <div class="card-block px-0 py-3">
             <div class="row form-sec">
                <div
                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                <div class="Publish-sec d-flex align-items-center justify-content-between">
                    <span class="font-14 black ml-1" style="width: auto !important;">Status :</span>
                    <label class="switch">
                        <input type="checkbox" id="is_featured_class" name="is_featured" @if(isset($data->status) && $data->status == '1') checked @endif >
                        <div class="slider round">
                            <span class="on">Yes</span>
                            <span class="off">No</span>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</form>
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

<script src='https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script>
    var $uploadCrop,
    tempFilename,
    rawImg,
    imageId;
    function readFile(input) {
        if (input.files && input.files[0]) {
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
        $('.item-img').val('');
        $('.cr-slider-wrap p').remove();
    });

    $('.item-img').on('change', function () { 
        readFile(this); 
    });

    $('.replacePhoto').on('click', function(){
        $('#cropImagePop').modal('hide');
        $('.item-img').trigger('click');
    })

    $('#cropImageBtn').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
                // format: 'jpeg',
                backgroundColor : "#000000",
                format: 'png',
                size: {width: 160, height: 160}
            }).then(function (resp) {
                $('#item-img-output').attr('src', resp);

                $('#cropImagePop').modal('hide');
                $('.item-img').val('');
                $('#image_new').val(resp);
                $('#old_img').val('');
                $('#image_file').val(resp);

            });
        });
    </script>

        <script>
        $('#daily_status_add').on('submit', function (e) {
            if ($('#daily_status_add').parsley().isValid() && ($('#image_new').val() != '') || $('#image_new').val() != '') {
               $('#daily_status_add').submit();
            } else {
                $('#error-message').show();
                e.preventDefault(); 
            }
        });
    </script>


    @endsection