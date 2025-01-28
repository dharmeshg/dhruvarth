@extends('layouts.backend.index')
@section('main_content')
<style>
    /* Styling for error messages */
    #error_messages {
        color: red;
        margin-top: 15px;
    }
    select[name="myTable_length"]{width: 64px !important;}
</style>
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                     <li class="breadcum-item"><a href="{{route('setting_all.index')}}">Bulk Upload</a></li>
                    <li class="breadcum-item active"><a href="javascript:;">Product Video Upload </a></li>
                </ul>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- [ Main Content ] start -->
                        <div class="row">
                            {{-- sample download section start --}}
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                                <div class="Recent-Users">
                                    <h5>Product Video Upload</h5>

                                    <div class="card-block px-0 py-3">
                                        <div class="row">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 bulk-img-sec">
                                                <div class="notice_area">
                                                    <h6>Instructions</h6>
                                                    <ul>
                                                        <li>At a time 20 Videos can be uploaded</li>
                                                        <li>Videos name has to product SKU. i.e Proudct SKU is JBG0308.So this Video name will be JBG0308.mp4. </li>
                                                        <li>Videos Size cant be more than 5MB.</li>
                                                        <li>Only mp4 videos can be uploaded.</li>
                                                    </ul>
                                                </div>
                                                <div id="dropzone-error-message" class="dropzone-error-message"></div>
                                                <div class="dropzone needsclick form-control" id="dropzone_demo"name="dropzone_demo">
                                                </div>
                                                <button type="button" class="common-submit-btn mt-3" id="upload_all_img">Upload</button>
                                                <div class="progress green d-none" id="progressmain">
                                                    <div class="progress-bar progress-bar-info progress-bar-striped active" id="progress_bar">
                                                        <div class="progress-value" id="progress-value">0 of 0</div>
                                                    </div>
                                                </div>
                                                <div class="faliur-main-sec d-none">
                                                    <h6>Product SKU not found.</h6>
                                                    <div id="error_messages" class="error-product-main">
                                                        <div class="row">

                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 bulk-img-sec">
                                                <h5>Uploaded Videos</h5>
                                                <div class="mb-3 filter-sec">
                                                    <div class="row input_group">
                                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                            <label>Search <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please search from SKU"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                            <input type="text" name="search_text" class="form-control" placeholder="Search" id="search_text">
                                                        </div>
                                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                            <label>Status <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please search by Status"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                            <select class="form-control" id="status_select" name="status" style="line-height: 21px;">
                                                                <option value="2">Please Select</option>
                                                                <option value="completed">Completed</option>
                                                                <option value="p_n_f">Product Not Found</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 btn-sec" style="margin-top: 33px;">
                                                            <button class="btn table-filter-btn" type="button" id="seach_filter" style="padding: 10px 20px;">Filter</button>
                                                            <a class="btn" style="color: #DE5757; display: none;" id="clear_filter">X Clear Filter</a>
                                                        </div>
                                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 btn-sec product-img-download">
                                                            <button class="btn table-filter-btn" type="button" id="download" style="padding: 10px 20px;">Export</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive" role="tabpanel" id="">
                                                    <table class="table table-hover display" id="myTable" style="width:100%">
                                                        <thead>
                                                            <tr class="unread">
                                                                <th scope="col">#</th>
                                                                {{-- <th scope="col">Image</th> --}}
                                                                <th scope="col">Product SKU</th>
                                                                <th scope="col">Status</th>
                                                                <th scope="col">Updated At</th>
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
                            {{-- sample download section end --}}
                           
                            
                        </div>
                    <!-- [ Main Content ] end -->
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
    var uploadedFilesCount = 0;
    const maxFilesAllowed = 20;
    var error_messages =[];
    const previewTemplate = `
        <div class="dz-preview dz-file-preview">
        <div class="dz-details">
            <div class="dz-thumbnail">
            <img data-dz-thumbnail>
            <span class="dz-nopreview">No preview</span>
            <div class="dz-success-mark"></div>
            <div class="dz-error-mark"></div>
            <div class="dz-error-message"><span data-dz-errormessage></span></div>
            <div class="progress">
                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
            </div>
            </div>
            <div class="dz-filename" data-dz-name></div>
            <div class="dz-size" data-dz-size></div>
        </div>
        </div>`;
        function appendErrorMessages() {
        $("#dropzone-error-message").html('');
            $.each(error_messages, function(index, value){
                $("#dropzone-error-message").append('<p class="dropzone_image-error">'+ value +'</p>');
            });
        }
    var myDropzone = new Dropzone("#dropzone_demo", {
        url: '/dropzone',
        previewTemplate: previewTemplate,
        parallelUploads: 1,
        maxFilesize: 5, // Max file size in MB
        maxFiles: 20, // Max number of files
        acceptedFiles: 'video/*', // Accept images only
        addRemoveLinks: true,
        dictDefaultMessage: '<p>Click Or Drop Files Here To Upload</p><i class="fa fa-upload" aria-hidden="true"></i>',
        init: function() {
            $("#upload_all_img").prop("disabled", true);
        this.on("error", function(file, response) {
            // console.log(file.upload.filename);
            if (!file.accepted) {
            this.removeFile(file);
            }
            var errorMessage = response;
            if (file.size > this.options.maxFilesize * 1024 * 1024) {
            errorMessage = `${file.upload.filename}: File size exceeds 5MB.`;
            if (!error_messages.includes(errorMessage)) {
                error_messages.push(errorMessage);
            }
            }
            if (!file.type.match('video.*')) {
            errorMessage = `${file.upload.filename}: Invalid file type. Only Videos are allowed.`;
            if (!error_messages.includes(errorMessage)) {
                error_messages.push(errorMessage);
            }
            }
            console.log(error_messages);
            appendErrorMessages();
        });
        this.on("addedfile", function(file) {
            uploadedFilesCount++;
            $("#upload_all_img").prop("disabled", false);
        });
        this.on("removedfile", function(file) {
            uploadedFilesCount--;
            if (uploadedFilesCount === 0) {
                $("#upload_all_img").prop("disabled", true);
            }
        });
        }
    });
    $("#upload_all_img").prop("disabled", true);

    $(document).on("click", "#upload_all_img", function() {
        $('#error_messages').html('');
        $('.faliur-main-sec').addClass('d-none');
        var totalFiles = myDropzone.files.length;
        var uploadedCount = 0;
        $('#progressmain').removeClass('d-none');
        // Update progress bar
        function updateProgress(count, total) {
            var percentage = (count / total) * 100;
            $('#progress_bar').css('width', percentage + '%');
            $('#progress-value').text(count + ' of ' + total);
        }

        // Initialize progress bar
        updateProgress(0, totalFiles);

        // Function to upload each file one by one
        function uploadFile(index) {
            if (index >= totalFiles) {
                myDropzone.removeAllFiles(true);
                toastr.success('All Files Proccessed Successfully.');
                $('#myTable').DataTable().ajax.reload();
                return; // All files processed
            }

            var data = new FormData();
            data.append('all_imgs[0]', myDropzone.files[index]);

            $.ajax({
                url: '{{ route('bulk.product.video.store') }}',
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {
                    uploadedCount++;
                    updateProgress(uploadedCount, totalFiles);
                    uploadFile(uploadedCount); // Upload next file
                },
                error: function(xhr, status, error) {
                    var errorMessage = 'Error uploading file ' + (index + 1);
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    $('.faliur-main-sec').removeClass('d-none');
                    $('#error_messages').append('<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12"><p class="failiurs_error">' + errorMessage + '</p></div>');
                    uploadedCount++;
                    updateProgress(uploadedCount, totalFiles);
                    uploadFile(uploadedCount); // Skip to next file
                }
            });
        }

        // Start uploading from the first file
        uploadFile(0);
    });
});
</script>
<script>
    var token = $("meta[name='csrf-token']").attr("content");
    var table;
    var search_text = $('#search_text').val();
    var status = $('#status_select').val();
    load_images(search_text,status);
    function load_images(search_text,status)
    {
        if ($.fn.DataTable.isDataTable('#myTable')) {
            table.destroy();
        }
        table = $('#myTable').DataTable({
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
            serverSide: true,
            ajax: {
                url: admin_url + "bulk-product-video-list",
                type: 'post',
                data: {
                    search_text: search_text,
                    status: status,
                    _token: token,
                },
            },

            columns: [{
                    data: 'ser_id',
                    name: 'id',
                    width: '1%'
                },
                // {
                //     data: 'img',
                //     name: 'img',
                //     width: '30%',
                //     orderable: false,
                //     searchable: false
                // },
                {
                    data: 'sku',
                    name: 'sku',
                    width: '20%',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    width: '20%',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'f_updated_at',
                    name: 'f_updated_at',
                    width: '10%',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    width: '9%',
                    orderable: true,
                    searchable: true
                },
            ],

            pagingType: 'simple_numbers',
            // dom: 'frtip',
            lengthMenu: [10, 50, 100, 250, 500],
            searching: false,
        });
    }

    $(document).on("click", "#seach_filter", function() {
        var search_text = $('#search_text').val();
        var status = $('#status_select').val();
        if(search_text == '' && status == '2')
        {
            $('#clear_filter').hide();
            toastr.error('Please Select At least one field');
        }else{
            $('#clear_filter').show();
            load_images(search_text,status);
        }
    });
    $(document).on("click", "#clear_filter", function() {
        $(this).hide();
        $('#search_text').val('');
        $('#status_select').val('2');
        var search_text = $('#search_text').val();
        var status = $('#status_select').val();
        load_images(search_text,status);
    });
    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).data('href');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete the Video and Also Removed from Product!',
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
</script>
<script>
    $(document).on("click","#download",function() {
        var search_text = $('#search_text').val();
        var status = $('#status_select').val();      
        var url = "{{route('bulk.product.video.download')}}";
        var token = '{{csrf_token()}}';
        var form = $('<form action="' + url + '" method="POST">' +
            '<input type="hidden" name="search_text" value="' + search_text + '" />' +'<input type="hidden" name="status" value="' + status + '" />' +
            '<input type="hidden" name="_token" value="' + token + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
        
    });
</script>
@endsection
