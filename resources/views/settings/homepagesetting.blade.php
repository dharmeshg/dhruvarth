@extends('layouts.backend.index')
@section('main_content')
<style>
.add-article .card-block label img{
  width: 35px;
  height: 35px;
  border-radius: 50%;
}
</style>
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('setting_all.index')}}"> Settings </a></li>
                     <li class="breadcum-item"><a href="{{route('global_settings.index')}}">Global Settings</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Homepage </a></li>
                </ul>
            </div>
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- <form action="{{ route('homepage_setting.store') }}" method="POST" data-parsley-validate="" enctype="multipart/form-data" id="home_form">
                        @csrf -->
                        <div class="row">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                                <div class="card Recent-Users">
                                    <div class="d-flex justify-content-between">
                                        <h5>Home Page Settings</h5>
                                        <!-- <button type="submit" class="btn btn-lg btn-primary" id="submit_form">Update Settings</button> -->
                                    </div>
                                    <div class="card-block px-0 py-3 home_page">
                                        <div class="row">
                                            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 section-list">
                                                @if(isset($home) && count($home) > 0)
                                                @foreach($home as $index=> $item)
                                                @php
                                                    $type = '';
                                                @endphp
                                                @if(isset($item->type) && $item->type != '' && $item->type != null)
                                                @php 
                                                if(isset($item->type) && $item->type == 'ads-poster')
                                                {
                                                     $sections = App\Models\MediaSection::where('id',$item->section_id)->first();
                                                     if(isset($sections) && $sections->image != ''){
                                                         $type = '<img src="' . asset('uploads/media/' . $sections->image) . '" alt="ADS Poster"> ADS Poster -';
                                                     }else{
                                                         $type = '<img src="' . asset('assets/images/user/img-demo_1041.jpg') . '" alt="ADS Poster"> ADS Poster -';
                                                     }
                                                   
                                                }
                                                if(isset($item->type) && $item->type == 'logo-slider')
                                                {
                                                   
                                                         $sections = App\Models\MediaSection::where('id',$item->section_id)->first();
                                                     if(isset($sections) && $sections->image != ''){
                                                         $type = '<img src="' . asset('uploads/media/' . $sections->image) . '" alt="Logo Slider"> Logo Slider -';
                                                     }else{
                                                         $type = '<img src="' . asset('assets/images/user/img-demo_1041.jpg') . '" alt="Logo Slider"> Logo Slider -';
                                                     }
                                                }
                                                if(isset($item->type) && $item->type == 'pdf-list')
                                                {
                                                   
                                                              $sections = App\Models\MediaSection::where('id',$item->section_id)->first();
                                                     if(isset($sections) && $sections->image != ''){
                                                         $type = '<img src="' . asset('uploads/media/' . $sections->image) . '" alt="PDF List"> PDF List -';
                                                     }else{
                                                         $type = '<img src="' . asset('assets/images/user/img-demo_1041.jpg') . '" alt="PDF List"> PDF List -';
                                                     }
                                                }
                                                if(isset($item->type) && $item->type == 'page-banner')
                                                {
                                                   
                                                                  $sections = App\Models\MediaSection::where('id',$item->section_id)->first();
                                                     if(isset($sections) && $sections->image != ''){
                                                         $type = '<img src="' . asset('uploads/media/' . $sections->image) . '" alt="Page Banner"> Page Banner -';
                                                     }else{
                                                          $type = '<img src="' . asset('assets/images/user/img-demo_1041.jpg') . '" alt="Page Banner"> Page Banner -';
                                                     }
                                                }
                                                @endphp
                                                @endif
                                                <div class="each_sec" >
                                                    <span class="arroa_span"><i class="fa fa-arrows"></i>
                                                    </span>
                                                    <div class="main_sec" data-order="{{ $index+1 }}" data-id="{{ $item->id }}">
                                                        <!-- <label for="">{{ isset($type) ? $type : '' }} {{ isset($item->title) ? $item->title : ''}} </label> -->
                                                        <label for="">{!! $type !!} @if(isset($item->image) && $item->image != '' && $item->image != null) <img src="{{ asset('uploads/images/' . $item->image)}}" alt="section-image"> @endif {{ isset($item->title) ? $item->title : ''}} </label>

                                                        
                                                        <div style="min-width:150px">
                                                            @if($item->type != 'testimonial' && $item->type != 'intro' && $item->type != 'youtube')
                                                            <label>Title Setting</label>
                                                            <label class="switch mb-0">
                                                                <input type="checkbox" id="slidersecbutton2" name="title_checked" data-id="{{ isset($item->id) ? $item->id : '' }}" @if(isset($item->checked_title) && $item->checked_title == 1) checked @endif>
                                                                <div class="slider round">
                                                                    <span class="on">Enable</span>
                                                                    <span class="off">Disable</span>
                                                                </div>
                                                            </label>
                                                            @endif
                                                        </div>   
                                                        

                                                        <div style="min-width:150px">
                                                            <label>Section Setting</label>
                                                            <label class="switch mb-0">
                                                                <input type="checkbox" id="slidersecbutton" name="slider_checked" data-id="{{ isset($item->id) ? $item->id : '' }}" @if(isset($item->checked) && $item->checked == 1) checked @endif>
                                                                <div class="slider round">
                                                                    <span class="on">Enable</span>
                                                                    <span class="off">Disable</span>
                                                                </div>
                                                            </label>
                                                        </div> 
                                                        
                                                        
                                                    </div>
                                                </div>
                                                @endforeach 
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- </form> -->
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

        });
        $(document).on('click', '#slidersecbutton', function() {
            var token = $("meta[name='csrf-token']").attr("content");
            var id = $(this).attr("data-id");
            var isChecked = $(this).is(':checked');
            var title = '';
            var previousState = isChecked;
            // if(isChecked == true)
            // {
            //     var title = 'Enable';
            // }else{
            //     var title = 'Disable';
            // }
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to disable/enable this Section!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, '+title+'!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                   
                        console.log(result.isConfirmed);
                if (result.isConfirmed == true) {
                         if(isChecked == true)
                            {
                                var title = 'Enable';
                            }else{
                                var title = 'Disable';
                            }
                    $.ajax({
                        url: admin_url + "update-section-status",
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
                }
            else{
                window.location = '{{ route('setting.homepage.index') }}';
                console .log(isChecked);
            //   if(isChecked == true)
            // {
            //     var title = 'Disable';
            //     $('#slidersecbutton').prop('checked', '');
            // }else{
            //     var title = 'Enable';
            //     $('#slidersecbutton').prop('checked', previousState);
            // }
                // $('#slidersecbutton').prop('checked', previousState);
            }
        });
        });

        $(document).on('click', '#slidersecbutton2', function() {
            var token = $("meta[name='csrf-token']").attr("content");
            var id = $(this).attr("data-id");
            var isChecked = $(this).is(':checked');
            var title = '';
            var previousState = isChecked;
            // if(isChecked == true)
            // {
            //     var title = 'Enable';
            // }else{
            //     var title = 'Disable';
            // }
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to disable/enable the section '+title+'!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, '+title+'!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                   
                        console.log(result.isConfirmed);
                if (result.isConfirmed == true) {
                         if(isChecked == true)
                            {
                                var title = 'Enable';
                            }else{
                                var title = 'Disable';
                            }
                    $.ajax({
                        url: admin_url + "update-section-status-title",
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
                }
            else{
                window.location = '{{ route('setting.homepage.index') }}';
                console .log(isChecked);
            //   if(isChecked == true)
            // {
            //     var title = 'Disable';
            //     $('#slidersecbutton').prop('checked', '');
            // }else{
            //     var title = 'Enable';
            //     $('#slidersecbutton').prop('checked', previousState);
            // }
                // $('#slidersecbutton').prop('checked', previousState);
            }
        });
        });
        $('.section-list').sortable({

            handle: '.arroa_span',

            cursor: "move",

            axis: 'y',

            update: function(e, u) {

                let data = $(this).sortable('serialize');

                updateSectionOrder();

            }

        });
        function updateSectionOrder() {

            let data = [];
            $('.section-list .main_sec').each(function(index) {
                let sectionId = $(this).data('id');
                data.push({ id: sectionId, order: index + 1 });
            });

            $.ajax({

                type: 'post',

                url: admin_url +"update-section-order",

                data: { sections: data },

                success: function(response) {

                    toastr.success(response.message);

                },

                error: function(xhr, status, error) {

                    let message = "Section Sorting Request Failed";

                    if (xhr.responseJSON) {

                        message = xhr.responseJSON.message;

                    }

                    toastr.error(message, 'ERROR!!');

                }

            });

        };
    </script>
    <script> 
        const assetPath = "{{ asset('assets/images/user/img-demo_1041.jpg') }}";

    </script>
    <script>
     $('#aboutsecbutton').click(function(){

     });
     $('#servicesecbutton').click(function(){

     });
     $('#storysecbutton').click(function(){

     });
     $('#testisecbutton').click(function(){

     });
     $('#marriedsecbutton').click(function(){

     });
     $('#gallerysecbutton').click(function(){

     });
     $('#postsecbutton').click(function(){

     });
     $('#formsecbutton').click(function(){

     });
     $('#videosecbutton').click(function(){

     });
     $('input[name="videotype"]').change(function() {

     });
 </script>
 <script>
    $( "#submit_form" ).on( "click", function() {
        var isValid = $('#home_form').parsley().isValid();
        if (isValid) {
            $('#home_form').submit();
        } else {
            toastr.error('Form validation failed. Please check the highlighted fields.');
        }
    });
</script>
@endsection
