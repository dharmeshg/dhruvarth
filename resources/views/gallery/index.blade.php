@extends('layouts.backend.index')
@section('main_content')
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <h5>Gallery</h5>
                                    <a href="{{ route('gallery.add') }}" class="add-article-btn">Add Gallery</a>
                                </div>
                                <div class="card-block px-0 py-3">
                                    <!-- <div class="example"> -->

                                    <!-- <div class="tab-content rounded-bottom"> -->
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Slug</th>
                                                    <th scope="col">Is Featured</th>
                                                    <th scope="col">Enable/Disable</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- </div> -->
                                    <!-- </div> -->
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
                sWidth: '19%'
            },
            {
                sWidth: '20%'
            },
            {
                sWidth: '10%'
            },
            {
                sWidth: '10%'
            },
            {
                sWidth: '10%'
            },
            {
                sWidth: '30%'
            }
        ],
        ajax: {
            url: admin_url + "list-gallery",
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
                data: 'image',
                name: 'image'
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'slug',
                name: 'slug'
            },
            {
                data: 'featured',
                name: 'featured'
            },
            {
                data: 'publish',
                name: 'publish'
            },
            {
                data: 'action',
                name: 'Action'
            }
        ]
    });
});

$(document).on('click', '.gallery_delete', function(e) {
    e.preventDefault();
    var deleteUrl = $(this).data('href');
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete the Gallery!',
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

$(document).on('click', '#is_publish', function() {
    var token = $("meta[name='csrf-token']").attr("content");
    var id = $(this).attr("data-id");
    var isChecked = $(this).is(':checked');
    $.ajax({
        url: '{{ route('gallery.publish_status') }}',
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
$(document).on('click', '#is_featured', function() {
    var token = $("meta[name='csrf-token']").attr("content");
    var id = $(this).attr("data-id");
    var isChecked = $(this).is(':checked');
    $.ajax({
        url: '{{ route('gallery.featured_status') }}',
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
});
</script>
@endsection