@extends('layouts.backend.index')
@section('main_content')

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('media.index')}}"> Media </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Add Poster</a></li>
                </ul>
            </div>

            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <h5>{{isset($sec_title->title) ? $sec_title->title : 'Posters'}} List</h5>
                                    <input type="hidden" name="slug" id="slug" value="{{ isset($slug) ? $slug : '' }}">
                                    <div>
                                    <a href="{{route('adsposter.add',['sec' => $slug])}}" class="add-article-btn">Add Poster</a>
                                    <a href="{{route('media.section',['sec' => 'ads-poster'])}}" class="add-article-btn">Back To Sections</a>
                                </div>
                                </div>
                                <div class="card-block px-0 py-3">

                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">Sr.No.</th>
                                                    <th scope="col">Poster Image</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Destination Link</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Status</th>
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
                sWidth: '5%'
            },
            {
                sWidth: '20%'
            },
            {
                sWidth: '20%'
            },
            {
                sWidth: '10%'
            },
            {
                sWidth: '15%'
            },
            {
                sWidth: '29%'
            }
            ],
            ajax: {
                url: admin_url + "list-ads-posters",
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
                searchable: false
            },
            {
                data: 'image',
                name: 'image',
                orderable: false,
                searchable: false
            },
            {
                data: 'select_type',
                name: 'select_type',
                orderable: false,
                searchable: true
            },
            {
                data: 'destination_link',
                name: 'destination_link',
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
                searchable: false
            }
            ],
            pagingType: 'simple_numbers',
        });


    });


    $(document).on('click', '#is_featured', function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        var isChecked = $(this).is(':checked');
        $.ajax({
            url: admin_url + "status-ads-posters",
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


    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).data('href');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete the Ads Poster!',
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
