@extends('layouts.backend.index')
@section('main_content')

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row ">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <h5>Services</h5>
                                    <a href="{{ route('products-services.add') }}" class="add-article-btn">Add Service</a>
                                        
                                </div>
                                <div class="card-body">
                                    <div class="example">

                                        <div class="card-block px-0 py-3">
                                            <div class="table-responsive" role="tabpanel" id="">
                                                <table class="table table-hover" id="myTable" style="width:100%">
                                                    <thead>
                                                        <tr class="unread">
                                                            <th scope="col">#</th>
                                                            <th scope="col">Image</th>
                                                            <th scope="col">Sub Title</th>
                                                            <th scope="col">Title</th>
                                                            <th scope="col">Price</th>
                                                            <th scope="col">Address</th>
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
                width: '10%', targets: 1 
            },
            {
                width: '19%', targets: 2 
            },
            {
                width: '20%', targets: 3 
            },
            {
                width: '10%', targets: 4 
            },
            {
                width: '25%', targets: 5 
            },
            {
                width: '15%', targets: 6 
            }
        ],
        ajax: {
            url: admin_url + "list-products-services",
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
                data: 'sub_title',
                name: 'sub_title'
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'price',
                name: 'price'
            },
            {
                data: 'address',
                name: 'address'
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
$(document).on('click', '.product_delete', function(e) {
    e.preventDefault();
    var deleteUrl = $(this).data('href');
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete the Products Services!',
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
@endsection