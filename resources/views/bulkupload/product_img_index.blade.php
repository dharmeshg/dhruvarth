<style>
    #error_messages {
        color: red;
        margin-top: 15px;
    }
    select[name="myTable_length"] {
        width: 64px !important;
    }
</style>
@extends('layouts.backend.index')
@section('main_content')
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="custom_breadcum">
                    <ul>
                        <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcum-item"><a href="{{route('setting_all.index')}}">Bulk Upload</a></li>
                        <li class="breadcum-item active"><a href="javascript:">Product Image Upload </a></li>
                    </ul>
                </div>
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <div
                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                                <div class="Recent-Users">
                                    <h5>Product Image Upload</h5>
                                    <div class="card-block px-0 py-3">
                                        <div class="row">
                                            <div
                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 bulk-img-sec">
                                                <div class="notice_area">
                                                    <h6>Instructions</h6>
                                                    <ul>
                                                        <li>At a time 100 images can be uploaded</li>
                                                        <li>Images name has to product SKU. i.e Proudct SKU is
                                                            JBG0308
                                                            and this contains four images then images name for that
                                                            product will be JBG0308-01,JBG0308-02.So this will
                                                            identify
                                                            and before '-' in image name will consider Product SKU.
                                                        </li>
                                                        <li>Images Size cant be more than 5MB.</li>
                                                        <li>Only .jpeg, .jpg, .png, .bmp, .webp, .svg can be
                                                            uploaded.
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div id="dropzone-error-message"
                                                     class="dropzone-error-message"></div>
                                                <div class="dropzone needsclick form-control" id="dropzone_demo">
                                                </div>
                                                <button type="button" class="common-submit-btn mt-3"
                                                        id="upload_all_img">Upload
                                                </button>
                                                <div class="progress green d-none" id="progressmain">
                                                    <div
                                                        class="progress-bar progress-bar-info progress-bar-striped active"
                                                        id="progress_bar">
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
                                            <div
                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3 bulk-img-sec">
                                                <h5>Uploaded Images</h5>
                                                <div class="mb-3 filter-sec">
                                                    <div class="row input_group">
                                                        <div
                                                            class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                            <label>Search <span data-bs-toggle="tooltip"
                                                                                data-bs-placement="right"
                                                                                title="Please search from SKU"><i
                                                                        class="fa fa-info-circle"
                                                                        aria-hidden="true"></i></span></label>
                                                            <input type="text" name="search_text"
                                                                   class="form-control"
                                                                   placeholder="Search" id="search_text">
                                                        </div>
                                                        <div
                                                            class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                            <label>Status <span data-bs-toggle="tooltip"
                                                                                data-bs-placement="right"
                                                                                title="Please search by Status"><i
                                                                        class="fa fa-info-circle"
                                                                        aria-hidden="true"></i></span></label>
                                                            <select class="form-control" id="status_select"
                                                                    name="status" style="line-height: 21px;">
                                                                <option value="2">Please Select</option>
                                                                <option value="completed">Completed</option>
                                                                <option value="p_n_f">Product Not Found</option>
                                                            </select>
                                                        </div>
                                                        <div
                                                            class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 btn-sec"
                                                            style="margin-top: 33px;">
                                                            <button class="btn table-filter-btn" type="button"
                                                                    id="seach_filter" style="padding: 10px 20px;">
                                                                Filter
                                                            </button>
                                                            <a class="btn" style="color: #DE5757; display: none;"
                                                               id="clear_filter">X Clear Filter</a>
                                                        </div>
                                                        <div
                                                            class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 btn-sec product-img-download">
                                                            <button class="btn table-filter-btn" type="button"
                                                                    id="bulk_delete"
                                                                    style="padding: 10px 20px;display:none;">Bulk Delete
                                                            </button>
                                                            <button class="btn table-filter-btn" type="button"
                                                                    id="download" style="padding: 10px 20px;">Export
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive" role="tabpanel" id="">
                                                    <table class="table table-hover display" id="myTable"
                                                           style="width:100%">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">
                                                                <input type="checkbox" id="selectAll">
                                                            </th>
                                                            <th scope="col">Image</th>
                                                            <th scope="col">Product SKU</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Priority</th>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script lang="text/javascript">
        $(document).ready(function () {
            let uploadedFilesCount = 0,
                error_messages = [];

            const previewTemplate = `
        <div class="dz-preview dz-file-preview">
        <div class="dz-details">
            <div class="dz-thumbnail">
            <img data-dz-thumbnail src="" alt="">
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
                $.each(error_messages, function (index, value) {
                    $("#dropzone-error-message").append('<p class="dropzone_image-error">' + value + '</p>');
                });
            }

            let myDropzone = new Dropzone("#dropzone_demo", {
                url: '/dropzone',
                previewTemplate: previewTemplate,
                parallelUploads: 1,
                maxFilesize: 5,
                maxFiles: 100,
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
                dictDefaultMessage: '<p>Click Or Drop Files Here To Upload</p><i class="fa fa-upload" aria-hidden="true"></i>',
                init: function () {
                    $("#upload_all_img").prop("disabled", true);
                    this.on("error", function (file, response) {
                        if (!file.accepted) {
                            this.removeFile(file);
                        }
                        let errorMessage = response;
                        if (file.size > this.options.maxFilesize * 1024 * 1024) {
                            errorMessage = `${file.upload.filename}: File size exceeds 5MB.`;
                            if (!error_messages.includes(errorMessage)) {
                                error_messages.push(errorMessage);
                            }
                        }
                        if (!file.type.match('image.*')) {
                            errorMessage = `${file.upload.filename}: Invalid file type. Only images are allowed.`;
                            if (!error_messages.includes(errorMessage)) {
                                error_messages.push(errorMessage);
                            }
                        }
                        console.log(error_messages);
                        appendErrorMessages();
                    });
                    this.on("addedfile", function () {
                        uploadedFilesCount++;
                        $("#upload_all_img").prop("disabled", false);
                    });
                    this.on("removedfile", function () {
                        uploadedFilesCount--;
                        if (uploadedFilesCount === 0) {
                            $("#upload_all_img").prop("disabled", true);
                        }
                    });
                }
            });

            $("#upload_all_img").prop("disabled", true);

            $(document).on("click", "#upload_all_img", function () {
                $('#error_messages').html('');
                $('.faliur-main-sec').addClass('d-none');
                let totalFiles = myDropzone.files.length;
                let uploadedCount = 0;
                $('#progressmain').removeClass('d-none');

                function updateProgress(count, total) {
                    let percentage = (count / total) * 100;
                    $('#progress_bar').css('width', percentage + '%');
                    $('#progress-value').text(count + ' of ' + total);
                }

                updateProgress(0, totalFiles);

                function uploadFile(index) {
                    if (index >= totalFiles) {
                        myDropzone.removeAllFiles(true);
                        toastr.success('All Files Proccessed Successfully.');
                        $('#myTable').DataTable().ajax.reload();
                        return;
                    }

                    let data = new FormData();
                    data.append('all_imgs[0]', myDropzone.files[index]);

                    $.ajax({
                        url: '{{ route('bulk.product.image.store') }}',
                        type: 'POST',
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function () {
                            uploadedCount++;
                            updateProgress(uploadedCount, totalFiles);
                            uploadFile(uploadedCount);
                        },
                        error: function () {
                            uploadedCount++;
                            updateProgress(uploadedCount, totalFiles);
                            uploadFile(uploadedCount);
                        }
                    });
                }

                uploadFile(0);
            });
        });

        let token = $("meta[name='csrf-token']").attr("content"),
            table,
            search_text = $('#search_text').val(),
            status = $('#status_select').val(),
            rowIds = [];

        load_images(search_text, status);

        function load_images(search_text, status) {
            if ($.fn.DataTable.isDataTable('#myTable')) {
                table.destroy();
            }
            table = $('#myTable').DataTable({
                language: {
                    search: "",
                    "searchPlaceholder": "Search",
                    "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>',
                    paginate: {
                        next: 'Next',
                        previous: 'Previous'
                    }
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: admin_url + "bulk-product-image-list",
                    type: 'post',
                    data: {
                        search_text: search_text,
                        status: status,
                        _token: token,
                    },
                },
                rowId: 'id',
                columns: [
                    {
                        data: '',
                        width: '1%',
                        orderable: false,
                        searchable: false,
                        defaultContent: '<input type="checkbox">',
                    },
                    {
                        data: 'img',
                        name: 'img',
                        width: '25%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'sku',
                        name: 'sku',
                        width: '15%',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        width: '15%',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'i_priority',
                        name: 'i_priority',
                        width: '12%',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'f_updated_at',
                        name: 'f_updated_at',
                        width: '13%',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width: '9%',
                        orderable: false,
                        searchable: false
                    },
                ],
                columnDefs: [
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0
                    }
                ],
                fixedColumns: {
                    start: 2
                },
                pagingType: 'simple_numbers',
                lengthMenu: [10, 50, 100, 250, 500],
                searching: false
            });
        }

        table.on('change', 'input[type="checkbox"]', function () {
            const rowId = $(this).closest('tr').attr('id');
            if (this.checked) {
                if (!rowIds.includes(rowId)) {
                    rowIds.push(rowId);
                }
            } else {
                rowIds = rowIds.filter(id => id !== rowId);
            }

            if (rowIds.length > 0) {
                $('#bulk_delete').show();
            } else {
                $('#bulk_delete').hide();
            }
        });

        $('#selectAll').on('click', function () {
            let state = this.checked;
            let rows = table.rows({filter: 'applied', page: 'current'}).nodes();

            $(rows).find('input[type="checkbox"]').prop('checked', state);

            if (state) {
                rows.each(function (value, index) {
                    const rowId = $(this)[index].id;
                    if (rowId && !rowIds.includes(rowId)) {
                        rowIds.push(rowId);
                    }
                });
                $('#bulk_delete').show();
            } else {
                rowIds = [];
                $('#bulk_delete').hide();
            }
        });


        $(document).on("click", "#seach_filter", function () {
            search_text = $('#search_text').val();
            status = $('#status_select').val();

            if (search_text === '' && status === '2') {
                $('#clear_filter').hide();
                toastr.error('Please Select At least one field');
            } else {
                $('#clear_filter').show();
                load_images(search_text, status);
            }
        });

        $(document).on("click", "#clear_filter", function () {
            $(this).hide();
            search_text = '';
            status = '2';
            load_images(search_text, status);
        });

        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            let deleteUrl = $(this).data('href');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete the Image and Also Removed from Product!',
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

        $(document).on("click", "#download", function () {
            let url = "{{route('bulk.product.image.list.download')}}",
                token = '{{csrf_token()}}',
                form = $('<form action="' + url + '" method="POST">' +
                    '<input type="hidden" name="search_text" value="' + search_text + '" />' + '<input type="hidden" name="status" value="' + status + '" />' +
                    '<input type="hidden" name="_token" value="' + token + '" />' +
                    '</form>');

            $('body').append(form);
            form.submit();
        });

        $('#bulk_delete').on('click', function () {
            console.log('this');
            if (rowIds.length > 0) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to delete the selected images!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete them!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{route('bulk-delete-product-image-upload')}}`,
                            method: 'POST',
                            data: {
                                ids: rowIds,
                                _token: token,
                            },
                            success: function () {
                                toastr.success('Images deleted successfully!');
                                table.ajax.reload();
                                rowIds = [];
                                $('#bulk_delete').hide();
                            },
                            error: function () {
                                toastr.error('Error deleting images');
                            }
                        });
                    }
                });
            }
        });
    </script>
@endsection
