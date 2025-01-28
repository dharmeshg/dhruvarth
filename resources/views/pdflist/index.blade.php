@extends('layouts.backend.index')
@section('main_content')

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('media.index')}}"> Media </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> PDF List</a></li>
                </ul>
            </div>
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <h5 id="modalCenterTitle">{{isset($sec_title->title) ? $sec_title->title : 'Pdf'}} List</h5>
                                    <input type="hidden" name="slug" id="slug" value="{{ isset($slug) ? $slug : '' }}">
                                    <div>
                                        <a href="" class="add-article-btn" data-bs-toggle="modal" data-bs-target="#pdflist_modal">Add New Pdf</a>
                                        <a href="{{route('media.section',['sec' => 'pdf-list'])}}" class="add-article-btn">Back To Sections</a>
                                    </div>
                                </div>
                                <div class="card-body card-block px-0 py-3">
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">Sr.No.</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">File</th>
                                                    <th scope="col">Date</th>
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



<div class="modal fade" id="pdflist_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle1">Add New Pdf</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPdfForm" action="{{ route('pdflist.save') }}" method="POST"
                        data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="pdf_id" name="pdf_id">
                        <input type="hidden" name="type" id="type" value="{{ isset($slug) ? $slug : '' }}">
                        <div class="input_group">
                            <div class="mb-3">
                                <label class="form-label" for="exampleFormControlInput1">Title <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter title"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <input class="form-control" id="title_new" name="title" type="text" required
                                    data-parsley-required-message="Please Enter Title"
                                    placeholder="Enter Title">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="exampleFormControlInput1">Pdf <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please choose pdf"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <input class="form-control" id="pdf" name="pdf" type="file" accept=".pdf" required
                                    data-parsley-required-message="Please Enter Pdf">
                                    <span id="file-extension-error" style="color: red;"></span>
                                    <span id="file-size-error" style="color: red;"></span>
                                <input type="hidden"  name="old_pdf" id="old_pdf">
                            </div>
                            <div class="mb-3">
                                <label>Cover Image <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Upload Cover Image For the PDF File"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label><span style="color: red;margin: 0;">*Recommended Size: 250x250 pixel upto 500KB.</span>
                                <p></p>
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                        <div class="me-3">
                                            <label class="img_upload daily_status_image" for="large_file"><i class="fa fa-plus mx-1"></i> Upload</label>
                                            <input type="file"  style="display: none;" id="large_file" name="cover_image" class="cover-item-img">
                                        </div>
                                        <div>
                                            <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="cover-item-img-output">
                                            <a class="show_close_icon" style="display: none;"><span class="remove_icons"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
                                        </div>
                                        <input type="hidden" name="cover_old_img" value="" id="old_img">
                                    </div>
                                </div>
                            </div>
                        
                            <div class="mb-3">
                                <button type="submit" class="btn btn-lg btn-primary" id="save_button">Save</button>
                                <button type="button" id="clear" name="clear"
                                    class="btn btn-lg btn-danger">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection
    @section('script')
    <script>
    $(document).ready(function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var slug = $('#slug').val();
        var table = $('#myTable').DataTable({
            language: {
                search: "",
                "searchPlaceholder": "Search",
                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>',
                paginate: {
                        next: 'Next', // 'Next' label for the next button
                        previous: 'Previous'
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
                url: admin_url + "list-pdf-list",
                type: 'post',
                data: {
                    _token: token,
                    slug: slug,
                },
            },

            columns: [{
                    data: 'ser_id',
                    name: 'id',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'title',
                    name: 'title',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'file',
                    name: 'file',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'date',
                    name: 'date',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'Action',
                    orderable: false,
                    searchable: true
                }
            ],
            pagingType: 'simple_numbers',
        });





        $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).data('href');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete the Pdf File!',
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

    $(document).on("click", ".edit", function() {
        $("#pdflist_modal").modal("show");
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        $.ajax({
            url: admin_url + "edit-pdf-list",
            type: "post",
            data: {
                _token: token,
                id: id,
            },
            success: function(response) {
                // console.log(response);
                //  var data = JSON.parse(data);
                // var data = response.data;
                // console.log("Received data:", data);
                if(response.status == 'success')
                {
                    $("#pdf_id").val(response.data.id);
                    $("#title_new").val(response.data.title);
                    $("#type").val(response.data.type);
                    $("#old_pdf").val(response.data.file);
                    $("#pdf").prop('required',false);
                    $('#old_img').val(response.data.cover_image);
                    if(response.data.cover_image && response.data.cover_image != '' && response.data.cover_image != null)
                    {
                       $('#cover-item-img-output').attr('src', '{{ asset('uploads/media/') }}' + '/' + response.data.cover_image); 
                       $('.show_close_icon').show();
                    }          
                    $("#modalCenterTitle1").html("Edit Pdf File");
                }
                else{
                    toastr.error(response.message);
                }
                
            },
        });
    });
    $(document).on("click", ".show_close_icon", function() {
        $('#cover-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}'); 
        $('#old_img').val('');
        $(this).hide();
    });

    $("#pdflist_modal").on("hidden.bs.modal", function () {
        // console.log("Modal hidden event");
            $(this).find("form").trigger("reset");
            // $('#add_metal_rate').parsley('reset');
            $('#addPdfForm').parsley().reset();
            $("#pdf_id").val("");
            $("#modalCenterTitle1").html("Add Pdf");
        });

    $(document).on("click", "#clear", function() {
        //  console.log("Clear button clicked");
        $("#pdf_id").val("");
        $("#title_new").val("");
        $("#pdf").val("");
    });


    });
    </script>
    <script>
   
    $(document).on('click', '#is_featured', function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        var isChecked = $(this).is(':checked');
        $.ajax({
            url: admin_url + "status-pdf-list",
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
    $(document).ready(function () {
        $('#pdf').change(function () {
            var allowedExtensions = /(\.pdf)$/i;
            var maxFileSize = 5 * 1024 * 1024; 
            var fileInput = this;

            // File extension check
            var fileName = $(fileInput).val();
            var fileExtension = fileName.split('.').pop();

            if (!allowedExtensions.exec(fileName)) {
                $('#file-extension-error').text('Only PDF files are allowed');
                $(fileInput).val('');
                $('#save_button').prop('disabled', true);
            } else {
                $('#file-extension-error').text('');
            }

            // File size check
            if (fileInput.files[0] && fileInput.files[0].size > maxFileSize) {
                $('#file-size-error').text('File size exceeds 5MB limit');
                $(fileInput).val('');
                $('#save_button').prop('disabled', true);
            } else {
                $('#file-size-error').text('');
            }

            if ($('#file-extension-error').text() === '' && $('#file-size-error').text() === '') {
                $('#save_button').prop('disabled', false);
            }
        });
    });
    $('.cover-item-img').on('change', function () { 

    var input = this;

        if (input.files && input.files[0]) {
            if (!input.files[0].type.startsWith('image/')) {
                $('#error-message').text('Please select a valid image file.');
                $('#error-message').show();
                $('.common-sub-btn').prop('disabled', true);
                $('.cover-item-img').val('');
                return;
            }
            var reader = new FileReader();

            reader.onload = function (e) {
                var img = new Image();
                img.src = e.target.result;


                img.onload = function () {
                    // if (img.width === 600 && img.height === 400 ) {
                        // Image is valid

                        $('#cover-item-img-output').attr('src', e.target.result);
                        $('#error-message').hide();
                        $('.common-sub-btn').prop('disabled', false);
                        $('#old_img').val();

                    // } else {
                    //     // Invalid image, reset input
                    //     $('#error-message').text('Please select a valid image with dimensions 600x400 and size up to 500kb.');
                    //     $('#error-message').show();
                    //     $('.common-sub-btn').prop('disabled', true);
                    //     $('.cover-item-img').val('');
                    // }
                };
            };

            reader.readAsDataURL(input.files[0]);
        } 
    });
</script>
    @endsection