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
                                    <h5>Add New Category</h5>
                                </div>
                                <div class="card-body">

                                    <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                                        <form id="addcategory" action="{{ route('categories.save') }}" method="POST"
                                            data-parsley-validate="">
                                            @csrf
                                            <input type="hidden" id="category_id" name="category_id">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">Name</label>
                                                <input class="form-control" id="name" name="name" type="text" required
                                                    data-parsley-required-message="Please Enter Name"
                                                    placeholder="Category Name">
                                                <span id="error_name" style="color:red;display:none;">This Name is
                                                    Already
                                                    Taken</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">Slug</label>
                                                <input class="form-control" id="slug" name="slug" type="text"
                                                    placeholder="Slug" required
                                                    data-parsley-required-message="Please Enter Slug">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlTextarea1">Parent
                                                    Category</label>
                                                <select class="form-select" id="parent_category" name="parent_category"
                                                    aria-label="Default select example">
                                                    <option value="0">--- Select Category ---</option>

                                                    @if(isset($categories))
                                                    @foreach($categories as $category)
                                                    <?php $dash=''; ?>
                                                    <option value="{{$category->id}}">{{$category->category}}</option>
                                                    @if(count($category->subcategory))
                                                    @include('subcategoryList-option',['subcategories' =>
                                                    $category->subcategory])
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="exampleFormControlTextarea1">Description</label>
                                                <textarea class="form-control" id="description" name="description"
                                                    rows="3"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-lg btn-primary">Save</button>
                                                <button type="button" id="clear" name="clear"
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
                                <h5>Category List</h5>
                                </div>
                                <div class="card-body card-block px-0 py-3">
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Category</th>
                                                    <th scope="col">Parent Category</th>
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
            fnInitComplete: function (oSettings, json) {
                    $button = $('<div class="bulk_action><select class="form-select" id="bulk_delete" name="bulk_action" aria-label="Default select example"><option value="0" selected>Bulk Action</option><option value="delete_select">Delete Selection</option></select></div>');

                    $("#myTable_filter").after($button);
                    $(".is-data-export-button").show();
                        },
            ajax: {
                url: admin_url + "category/list-test",
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
                    data: 'category',
                    name: 'Category'
                },
                {
                    data: 'parent_category',
                    name: 'Parent Category'
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
    $(document).on('change', '#name', function(e) {
        const $nameInput = $("#name");
        const $slugInput = $("#slug");
        var token = $("meta[name='csrf-token']").attr("content");
        var val = $(this).val();
        $.ajax({
            url: "{{ route('category.check_slug') }}",
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
    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).data('href');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete the Categories!',
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
            url: admin_url + "category/edit",
            type: "post",
            data: {
                _token: token,
                id: id,
            },
            success: function(data) {
                var data = JSON.parse(data);
                var category_list = data.categories;
                $("#category_id").val(data.id);
                $("#name").val(data.category);
                $("#slug").val(data.slug);
                $("#parent_category").val(data.parent_category);
                $("#description").val(data.description);
                $("#sections").val(data.sections_id);


                $("#modalCenterTitle").html("Edit Category");

                var optionToHide = $("#parent_category option[value='" + data.id + "']");
                optionToHide.css("display", "none");

                for (var i = 0; i < category_list.length; i++) {
                    var categoryId = category_list[i].id;

                    var optionToHide = $("#parent_category option[value='" + categoryId + "']");
                    optionToHide.css("display", "none");

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
            url: admin_url + "check/featured-category",
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