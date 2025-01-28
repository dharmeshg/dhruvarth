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
                                    <h5>How to get Married</h5>
                                    <a href="{{ route('married.add') }}" class="add-article-btn">Add How to get Married</a>
                                </div>
                                <div class="card-block px-0 py-3">
                               
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Slug</th>
                                                    <!-- <th scope="col">Url</th> -->
                                                    <th scope="col">Button Name</th>
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
                next: '&gt;',
                previous: '&lt;'
            }
        },
        processing: true,
        autoWidth: false,
        columnDefs: [
            { 
                targets: [0, 6],
                 orderable: false,
            },
            {
                width: '1%', targets: 0 
            },
            {
                width: '9%', targets: 1 
            },
            {
                width: '20%', targets: 2 
            },
            {
                width: '20%', targets: 3 
            },
            {
                width: '25%', targets: 4 
            },
            {
                width: '10%', targets: 5 
            },
            {
                width: '15%', targets: 6 
            },
            // {
            //     width: '10%', targets: 7 
            // }
        ],
        ajax: {
            url: admin_url + "list-married",
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
            // {
            //     data: 'url',
            //     name: 'url'
            // },
            {
                data: 'button_name',
                name: 'button_name'
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

$(document).on('click', '.married_delete', function(e) {
    e.preventDefault();
    var deleteUrl = $(this).data('href');
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete the Married!',
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

$(document).on('click', '#married_status', function() {
    var token = $("meta[name='csrf-token']").attr("content");
    var id = $(this).attr("data-id");
    var isChecked = $(this).is(':checked');
    $.ajax({
        url: '{{ route('married.status') }}',
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