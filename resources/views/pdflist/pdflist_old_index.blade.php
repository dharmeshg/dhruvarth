@extends('layouts.backend.index')
@section('main_content')

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">

            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <!-- <strong id="modalCenterTitle">Add New Category</strong> -->
                                    <h5 id="modalCenterTitle">Add New Pdf</h5>
                                </div>
                                <div class="card-body">

                                    <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                                        <form id="addcategory" action="{{ route('pdflist.save') }}" method="POST"
                                            data-parsley-validate="" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" id="pdf_id" name="pdf_id">
                                            <div class="input_group">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">Title</label>
                                                <input class="form-control" id="title" name="title" type="text" required
                                                    data-parsley-required-message="Please Enter Title"
                                                    placeholder="Enter Title">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">Pdf</label>
                                                <input class="form-control" id="pdf" name="pdf" type="file" accept=".pdf" required
                                                    data-parsley-required-message="Please Enter Pdf">
                                                     <span id="file-extension-error" style="color: red;"></span>
                                                     <span id="file-size-error" style="color: red;"></span>
                                                <input type="hidden"  name="old_pdf" id="old_pdf">
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
                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <!-- <strong>Category List</strong> -->
                                <h5>Pdf List</h5>
                                </div>
                                <div class="card-body card-block px-0 py-3">
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">File</th>
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


    @endsection
    @section('script')

    <script>
    $(document).ready(function() {
        var token = $("meta[name='csrf-token']").attr("content");

        var table = $('#myTable').DataTable({
            language: {
                search: "",
                "searchPlaceholder": "Search",
                "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>',
                paginate: {
                    next: '&gt;', // or '→'
                    previous: '&lt;' // or '←' 
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
                },
            },

            columns: [{
                    data: 'ser_id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'file',
                    name: 'file'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'Action'
                }
            ]
        });


    });
    </script>
    <script>
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
                if(response.status == 'success')
                {
                    var data = response.data;
                    $("#pdf_id").val(data.id);
                    $("#title").val(data.title);
                    // $("#pdf").val(data.file);
                    $("#old_pdf").val(data.file);
                    $("#pdf").prop('required',false);
                    $("#modalCenterTitle").html("Edit Pdf File");
                }else{
                    toastr.error(response.message);
                }
                // $("#slug").prop("readonly", true);
            },
        });
    });
    $(document).on("click", "#clear", function() {
        $("#category_id").val("");
        $("#name").val("");
        $("#slug").val("");
        $("#parent_category").val("");
        $("#description").val("");
        $("#sections").val("");
        $("#modalCenterTitle").html("Add New Category");
        var optionToHide = $("#parent_category option");
        optionToHide.css("display", "block");

        $("#parent_category").val("0");
        $("#slug").prop("readonly", false);

    })

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
</script>
    @endsection