@extends('layouts.backend.index')
@section('main_content')
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">

                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row ">
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <!-- <strong>Category List</strong> -->
                                        <h5>Add New Tag</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                                            <form id="addtags" action="{{ route('tags.save') }}" method="POST"
                                                data-parsley-validate="">
                                                @csrf
                                                <input type="hidden" id="tags_id" name="tags_id">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Name</label>
                                                    <input class="form-control" id="name" name="name" type="text"
                                                        required data-parsley-required-message="Please Enter Title"
                                                        placeholder="Please Enter Title">
                                                    <span id="error_name" style="color:red;display:none;">This Name is
                                                        Already Taken</span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Slug</label>
                                                    <input class="form-control" id="slug" name="slug" type="text"
                                                        placeholder="Slug" required
                                                        data-parsley-required-message="Please Enter Slug">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="exampleFormControlTextarea1">Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-lg btn-primary">Save</button>
                                                    <button type="button" id="tags_clear" name="clear"
                                                        class="btn btn-lg btn-danger">Clear</button>
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
                                        <h5>Tag List</h5>
                                    </div>
                                    <div class="card-body card-block px-0 py-3">
                                        <div class="table-responsive" role="tabpanel" id="">
                                            <table class="table table-hover" id="tags_table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Slug</th>
                                                        <th scope="col">Description</th>
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
            var table = $('#tags_table').DataTable({
                language: {
                    search: "",
                    "searchPlaceholder": "Search",
                    "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>',
                    paginate: {
                        next: '&gt;',
                        previous: '&lt;'
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
                    url: admin_url + "tags/list",
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
                        data: 'name',
                        name: 'Name'
                    },
                    {
                        data: 'slug',
                        name: 'Slug'
                    },
                    {
                        data: 'description',
                        name: 'Description'
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


        })
    </script>
    <script>
        $(document).on('change', '#name', function(e) {
            const $nameInput = $("#name");
            const $slugInput = $("#slug");
            var token = $("meta[name='csrf-token']").attr("content");
            var val = $(this).val();
            $.ajax({
                url: "{{ route('tag.check_slug') }}",
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
    <script>
        $(document).on('click', '.tags_delete', function(e) {
            e.preventDefault();
            var deleteUrl = $(this).data('href');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete the Tags!',
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

        $(document).on("click", ".tags_edit", function() {
            var token = $("meta[name='csrf-token']").attr("content");
            var id = $(this).attr("data-id");
            $.ajax({
                url: admin_url + "tags/edit",
                type: "post",
                data: {
                    _token: token,
                    id: id,
                },
                success: function(data) {
                    var data = JSON.parse(data);
                    // var category_list = data.categories;
                    $("#tags_id").val(data.id);
                    $("#name").val(data.name);
                    $("#slug").val(data.slug);
                    $("#description").val(data.description);

                    $("#modalCenterTitle").html("Edit Tags");
                    $("#slug").prop("readonly", true);

                },
            });
        });
        $(document).on("click", "#tags_clear", function() {
            $("#tags_id").val("");
            $("#name").val("");
            $("#slug").val("");
            $("#description").val("");
            $("#modalCenterTitle").html("Add New Tags");
            $("#slug").prop("readonly", false);


        })

        $(document).on('click', '#is_featured', function() {
            var token = $("meta[name='csrf-token']").attr("content");
            var id = $(this).attr("data-id");
            var isChecked = $(this).is(':checked');
            $.ajax({
                url: admin_url + "check/featured-tags",
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
@endsection
