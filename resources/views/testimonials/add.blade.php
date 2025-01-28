@extends('layouts.backend.index')
@section('main_content')
<style>
.rating { 
  border: none;
  float: left;
}

.rating > input { display: none; } 
.rating > label:before { 
  margin: 5px;
  font-size: 1.25em;
  font-family: FontAwesome;
  display: inline-block;
  content: "\f005";
}

.rating > .half:before { 
  content: "\f089";
  position: absolute;
}

.rating > label { 
  color: #ddd; 
 float: right; 
 font-size: 20px;
}

/***** CSS Magic to Highlight Stars on Hover *****/

.rating > input:checked ~ label, /* show gold star when clicked */
.rating:not(:checked) > label:hover, /* hover current star */
.rating:not(:checked) > label:hover ~ label { color: #F79426;  } /* hover previous stars in list */

.rating > input:checked + label:hover, /* hover current star when changing rating */
.rating > input:checked ~ label:hover,
.rating > label:hover ~ input:checked ~ label, /* lighten current selection */
.rating > input:checked ~ label:hover ~ label { color: #F79426;  } 
</style>
 <div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
          <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="javascript:;"> Settings </a></li>
                    <li class="breadcum-item"><a href="{{route('global_settings.index')}}">Global Settings</a></li>
                    <li class="breadcum-item"><a href="{{route('testimonials.index')}}"> Testimonials</a></li>
                    <!-- <li class="breadcum-item active"><a href="{{route('testimonials.add')}}"> Add Testimonial</a></li> -->
                    <li class="breadcum-item active"><a href="{{route('testimonials.add')}}"    > {{ isset($testimonial) ? 'Edit' : 'Add' }} Testimonial</a></li>
                </ul>
            </div>
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="d-flex align-items-center justify-content-between">
                        <!-- <h3 class="add_heading">Add Testimonial</h3> -->
                        <h3 class="">{{ isset($testimonial) ? 'Edit' : 'Add' }} Testimonial</h3>
                        <a href="{{ route('testimonials.index') }}" class="back-btn">Back to Testimonial</a>
                    </div>
                    <!-- <form id="slide_testimonial_add" action="{{ route('testimonials.store') }}" method="POST" enctype='multipart/form-data' data-parsley-validate> -->
                    <form id="slide_banner_add" action="{{  route('testimonials.store') }}" method="POST" enctype='multipart/form-data' data-parsley-validate>
                        @csrf
                        <input type="hidden" name="testimonial_id" value="{{ isset($testimonial->id) ? $testimonial->id : '' }}">
                        <div class="input_group">
                            <div class="row">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="row form-sec">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <label class="form-label" for="exampleFormControlInput1">Rating <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select The Rating" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                            </div>
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                             <div class="rating">
                                                <input type="radio" id="star5" name="rating" value="5" {{ isset($testimonial->rating) && $testimonial->rating == '5' ? 'checked' : '' }}/><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                <input type="radio" id="star4half" name="rating" value="4.5" {{ isset($testimonial->rating) && $testimonial->rating == '4.5' ? 'checked' : '' }}/><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                <input type="radio" id="star4" name="rating" value="4" {{ isset($testimonial->rating) && $testimonial->rating == '4' ? 'checked' : '' }}/><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                <input type="radio" id="star3half" name="rating" value="3.5" {{ isset($testimonial->rating) && $testimonial->rating == '3.5' ? 'checked' : '' }}/><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                <input type="radio" id="star3" name="rating" value="3" {{ isset($testimonial->rating) && $testimonial->rating == '3' ? 'checked' : '' }}/><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                <input type="radio" id="star2half" name="rating" value="2.5" {{ isset($testimonial->rating) && $testimonial->rating == '2.5' ? 'checked' : '' }}/><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                <input type="radio" id="star2" name="rating" value="2" {{ isset($testimonial->rating) && $testimonial->rating == '2' ? 'checked' : '' }}/><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                <input type="radio" id="star1half" name="rating" value="1.5" {{ isset($testimonial->rating) && $testimonial->rating == '1.5' ? 'checked' : '' }}/><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                <input type="radio" id="star1" name="rating" value="1" {{ isset($testimonial->rating) && $testimonial->rating == '1' ? 'checked' : '' }}/><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                <input type="radio" id="starhalf" name="rating" value="0.5" {{ isset($testimonial->rating) && $testimonial->rating == '0.5' ? 'checked' : '' }}/><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>

                                          </div>

                                      </div>
                                  </div>
                                  <div class="mb-3">
                                            <label class="form-label" for="exampleFormControlInput1">User Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Insert User Name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
                                            <input class="form-control" id="name" name="name" type="text"
                                            required data-parsley-required-message="Please Enter User Name"
                                            placeholder="Enter User Name" value="{{ isset($testimonial->name) ? $testimonial->name : '' }}">
                                        </div>
                                  <div class="mb-3">
                                                    <div>
                                                    <label class="form-label"
                                                        for="exampleFormControlTextarea1">City <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Insert City Name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label></div>
                                                    <input id="autocomplete_search" name="autocomplete_search" type="text" class="form-control" placeholder="Enter City" value="{{ isset($testimonial->phone) ? $testimonial->phone: '' }}">
                                                <input type="hidden" name="lat"  value="{{ isset($testimonial->lat) ? $testimonial->lat: '' }}">
                                                <input type="hidden" name="long"  value="{{ isset($testimonial->long) ? $testimonial->long: '' }}">
                                                    </div>
                                  <div class="mb-3">
                                    <div>
                                        <label class="form-label" for="exampleFormControlTextarea1">Review 
                                            <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Insert Review">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            </span>
                                        </label>
                                    </div>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Review">{{ isset($testimonial->sub_content) ? $testimonial->sub_content : '' }}</textarea>
                                        <br><button type="submit" class="common-submit-btn">Submit</button>
                                       <!--  <button type="button" id="tags_clear" name="clear"
                                        class="btn btn-lg btn-danger">Clear</button> -->
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

@endsection
@section('script')
<script>
    $(document).ready(function() {
     $('#code_preview0').summernote({height: 300});
     });
</script>
    <script>
        const assetPath = "{{ asset('assets/images/user/img-demo_1041.jpg') }}";
        
        $('#remove_image').click(function(event) {
            event.stopPropagation(); 
            $('#img_id').val(null);

            $('#profile_avtar').attr('src', assetPath);
            $('#remove_image').css('display', 'none');
            $('#profile_avtar').css('opacity', '1.0');
        });
    </script>
    <script>
        $(document).on('change', '#testi_name', function(e) {
            const $nameInput = $("#testi_name");
            const $slugInput = $("#testi_Slug");
            var token = $("meta[name='csrf-token']").attr("content");
            var val = $(this).val();
            $.ajax({
                url: "",
                method: "POST",
                data: {
                    _token: token,
                    name: val
                },
                success: function(response) {
                    if (response.status == 1) {
                        $('#error_name').show();
                    } else {
                        $('#error_name').hide();
                        const nameValue = $nameInput.val();
                        const slugValue = nameValue.replace(/\s+/g, "-").toLowerCase();
                        $slugInput.val(slugValue);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Something Went Wrong!');
                }
            });
        });
    </script>
@endsection
