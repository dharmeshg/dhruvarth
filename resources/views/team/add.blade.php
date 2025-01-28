@extends('layouts.backend.index')
@section('main_content')
    <style>
        input[type="checkbox"] {
            position: relative;
            appearance: none;
            width: 35px;
            height: 20px;
            background: #ccc;
            border-radius: 50px;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: 0.4s;
        }

        input:checked[type="checkbox"] {
            background: #321fdb;
        }

        input[type="checkbox"]::after {
            position: absolute;
            content: "";
            width: 20px;
            height: 20px;
            top: 0;
            left: 0;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            transform: scale(1.1);
            transition: 0.4s;
        }

        input:checked[type="checkbox"]::after {
            left: 50%;
        }

        .site_logo {
            display: flex;
            align-items: center;
        }

        .site_logo .upload_image {
            border: 1px solid #321fdb;
            color: #321fdb !important;
            font-size: 16px !important;
            font-weight: 500 !important;
            line-height: 26px !important;
            letter-spacing: 0.16px;
            padding: 14px 30px;
            margin: 0 0 0 30px !important;
            width: unset !important;
            cursor: pointer;
        }

        .remove_image {
            display: none;
            position: absolute;
            top: 44%;
            left: 41%;
            cursor: pointer;
        }

        .remove_image1 {
            display: none;
            position: absolute;
            top: 44%;
            left: 41%;
            cursor: pointer;
        }

        .main_figure:hover .remove_image {
            display: block;
        }

        .main_figure:hover .profile_avtar {
            opacity: 0.5;
        }

        .main_figure:hover .remove_image1 {
            display: block !important;
        }

        .main_figure:hover .profile_avtar1 {
            opacity: 0.5;
        }
    </style>
    <div class="row ">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-header article_heading">
                    @if (isset($testi) && $testi != '')
                        <strong id="modalCenterTitle">Edit Member</strong>
                    @else
                        <strong id="modalCenterTitle">Add Member</strong>
                    @endif
                </div>
                <div class="card-body">
                    <div class="example">
                        @if (isset($testi) && $testi != '')
                            <form action="{{ route('testimonials.update', ['id' => $testi->id]) }}" method="POST"
                                data-parsley-validate="" enctype="multipart/form-data">
                            @else
                                <form action="{{ route('testimonials.store') }}" method="POST" data-parsley-validate=""
                                    enctype="multipart/form-data">
                        @endif
                        @csrf
                        <div class="tab-content rounded-bottom">
                            <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                                <div class="row">
                                <div class="col-12">
                                    <label class="form-label" for="">Image</label>
                                    <div class="mb-3 site_logo">
                                        <figure id="image-figure" class="main_figure" style=" position: relative; ">
                                            @if (isset($testi->img) && $testi->img != '')
                                                <img src="{{ asset('uploads/' . $testi->img) }}"
                                                    alt="" class="img-fluid profile_avtar" id="profile_avtar"
                                                    style="width:125px;height:125px;border-radius: 50%;">

                                                <img src="{{ asset('assets/img/register-delete.svg') }}"
                                                    alt="" class="img-fluid remove_image" id="remove_image">
                                            @else
                                                <img src="{{ asset('assets/img/new-profile.svg') }}" alt=""
                                                    class="img-fluid profile_avtar1" id="profile_avtar"
                                                    style="width:125px;height:125px;border-radius: 50%;">
                                                <img src="{{ asset('assets/img/register-delete.svg') }}"
                                                    alt="" class="img-fluid remove_image1" id="remove_image"
                                                    style="display:none;">
                                            @endif
                                        </figure>
                                        <label class="form-label upload_image" for="file">Upload Picture</label>
                                        <input class="form-control" id="file" name="member_img" type="file"
                                            placeholder="Category Name" style="display:none"
                                            onchange="loadFile(event)">
                                        <input type="hidden" name="old_img" id="old_img"
                                            value="{{ isset($testi->img) ? $testi->img : '' }}">
                                    </div>
                                    <span id="logo_required"></span>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                    <div class="mb-3">
                                        <input type="hidden" name="article_id"
                                            value="{{ isset($testi->id) ? $testi->id : '' }}">
                                        <label for="inputtitle" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="inputtitle" name="member_name"
                                            required data-parsley-required-message="Please Enter Name" placeholder="Name"
                                            value="{{ isset($testi->name) ? $testi->name : '' }}">
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleFormControlTextarea1">E-mail</label>
                                        <input type="text" class="form-control" id="inputtitle" name="member_email"
                                            required data-parsley-required-message="Please Enter E-Mail"
                                            value="{{ isset($testi->email) ? $testi->email : '' }}" placeholder="E-Mail">
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleFormControlTextarea1">Phone</label>
                                        <input type="text" class="form-control imput-mask" id="inputtitle" name="member_phone"
                                            value="{{ isset($testi->phone) ? $testi->phone : '' }}" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleFormControlTextarea1">Content</label>
                                        <textarea name="member_content" data-parsley-required="true" class="form-control" id="editor1" rows="10"
                                            cols="80" data-parsley-required-message="Please enter Content"
                                            data-parsley-errors-container="#content_required"> {{ isset($testi->content) ? $testi->content : '' }} </textarea>
                                        <span id="content_required"></span>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleFormControlInput1">Publish
                                            Date</label>
                                        <input type="date" class="form-control" id="inputtitle"
                                            name="article_published_at"
                                            value="{{ isset($article->published_at) ? $article->published_at : '' }}">
                                    </div>
                                </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="exampleFormControlInput1">Status</label>
                                            <div class="form-group row my-2">
                                                <label for="is_featured" class="col-sm-6 font-14 bold black">Featured
                                                    Status
                                                </label>
                                                <div class="col-sm-6">
                                                    <label class="switch glow primary medium">
                                                        <input type="checkbox" name="is_featured"
                                                            @if (isset($testi) && $testi->is_featured == '1') checked @endif>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-lg btn-primary">Save</button>
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
    <script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor1');
        autoUpdateElement: true,

            CKEDITOR.on('instanceReady', function() {
                $.each(CKEDITOR.instances, function(instance) {
                    CKEDITOR.instances[instance].on("change", function(e) {
                        for (instance in CKEDITOR.instances)
                            CKEDITOR.instances[instance].updateElement();
                    });
                });
            });
    </script>
    <script>
        const assetPath = "{{ asset('assets/img/new-profile.svg') }}";
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function() {

                $('#profile_avtar').attr('src', reader.result);
            };

            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            } else {}
        };
        $('#remove_image').click(function(event) {
            event.stopPropagation(); // Prevent click event propagation to the parent label
            $('#artical_img').val(null);
            $('#old_img').val(null);

            $('#profile_avtar').attr('src', assetPath);
            $('#remove_image').css('display', 'none');
            $('#profile_avtar').css('opacity', '1.0');
        });
    </script>
    
@endsection
