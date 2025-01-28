@extends('layouts.backend.index')
@section('main_content')
<style>
    #myTable .p_status{display: block; width: 95px; text-align: center; color: #fff; border-radius: 10px;}
    select[name="myTable_length"]{width: 64px !important;}
    div[role="progressbar"] {
        --size: 70px;
        --fg: var(--theme-orange-red);
        --bg: #e3e3e3;
        --pgPercentage: var(--value);
        animation: growProgressBar 3s 1 forwards;
        width: var(--size);
        height: var(--size);
        border-radius: 50%;
        display: grid;
        place-items: center;
        background: 
            radial-gradient(closest-side, white 80%, transparent 0 99.9%, white 0),
            conic-gradient(var(--fg) calc(var(--pgPercentage) * 1%), var(--bg) 0)
            ;
        font-family: Helvetica, Arial, sans-serif;
        font-size: calc(var(--size) / 5);
        color: var(--fg);
    }

    div[role="progressbar"]::before {
    counter-reset: percentage var(--value);
    content: counter(percentage) '%';
    }
</style>
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                     <li class="breadcum-item"><a href="{{route('setting_all.index')}}">Bulk Upload</a></li>
                    <li class="breadcum-item active"><a href="javascript:;">Bulk Product Upload </a></li>
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
                                    <h5>Sample Download</h5>

                                    <div class="card-block px-0 py-3">
                                        <div class="row">
                                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-sec">
                                                        <label for="">Select Category <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Category" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                                                        <select name="category" class="form-control select2" id="d_category">
                                                            <option value="">Select</option>
                                                            @if(isset($categories) && count($categories) > 0)
                                                            @foreach($categories as $category) 
                                                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
                                                <button class="btn table-filter-btn" type="button" id="attr_download">Attribute Download</button>
                                                <button class="btn table-filter-btn" type="button" id="sample_download">Sample Products Download</button>
                                                {{-- <button class="btn table-filter-btn" type="button" id="sample_variants_download">Sample Variants Download</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            {{-- sample download section end --}}
                            {{-- bulk upload section start --}}
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12 add-article form-main-sec mt-3">
                                <div class="Recent-Users">
                                    <h5>Bulk Product Upload</h5>
                                    <form action="{{ route('bulk.product.store') }}" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-block px-0 py-3">
                                            <div class="row">
                                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="form-sec">
                                                            <label for="">Select Category <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Category" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                                                            <select name="u_category" class="form-control select2" id="u_category" required data-parsley-required-message="Please Select Category" data-parsley-errors-container="#cat_error">
                                                                <option value="">Select</option>
                                                                @if(isset($categories) && count($categories) > 0)
                                                                @foreach($categories as $category) 
                                                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                            <span id="cat_error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="form-sec">
                                                        <label for="">Upload File <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload csv file" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                                                        <input class="form-control" id="file" name="file" type="file" accept=".csv"  required="" data-parsley-required-message="Please Choose CSV file">
                                                    </div>
                                                </div>
                                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <button type="submit" class="common-submit-btn">Upload</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> 
                            {{-- bulk upload section end --}}
                            {{-- bulk product list section start --}}
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12 add-article form-main-sec mt-3">
                                <div class="Recent-Users">
                                    <h5>Bulk Upload Product List</h5>
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover display" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Category</th>
                                                    <th scope="col">Uploaded File</th>
                                                    <th scope="col">Invalid File</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Progress</th>
                                                    <th scope="col"><img src="{{asset('images/dashbord/Eye image.png')}}" class="image-fuild w-auto" alt="user-img"></th>
                                                    <th scope="col">Updated At</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> 
                            {{-- bulk product list section end --}}
                        </div>
                    <!-- [ Main Content ] end -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="backend-loading d-none"></div>
</div>
@endsection
@section('script')
<script>
    $(document).on("click","#attr_download",function() {
        var selected_cat = $('#d_category').val();
        if(selected_cat == '')
        {
            toastr.error('Please Select Category');
        }else{
            var url = "{{route('bulk.attr.download')}}";
            var token = '{{csrf_token()}}';
            var form = $('<form action="' + url + '" method="POST">' +
                '<input type="hidden" name="selected_cat" value="' + selected_cat + '" />' +
                '<input type="hidden" name="_token" value="' + token + '" />' +
                '</form>');
            $('body').append(form);
            form.submit();
        }
    });
    $(document).on("click","#sample_download",function() {
        var selected_cat = $('#d_category').val();
        if(selected_cat == '')
        {
            toastr.error('Please Select Category');
        }else{
            var url = "{{route('bulk.sample.download')}}";
            var token = '{{csrf_token()}}';
            var form = $('<form action="' + url + '" method="POST">' +
                '<input type="hidden" name="selected_cat" value="' + selected_cat + '" />' +
                '<input type="hidden" name="_token" value="' + token + '" />' +
                '</form>');
            $('body').append(form);
            form.submit();
        }
    });
    $(document).on("click","#sample_variants_download",function() {
        var selected_cat = $('#d_category').val();
        if(selected_cat == '')
        {
            toastr.error('Please Select Category');
        }else{
            var url = "{{route('bulk.sample.variant.download')}}";
            var token = '{{csrf_token()}}';
            var form = $('<form action="' + url + '" method="POST">' +
                '<input type="hidden" name="selected_cat" value="' + selected_cat + '" />' +
                '<input type="hidden" name="_token" value="' + token + '" />' +
                '</form>');
            $('body').append(form);
            form.submit();
        }
    });
</script>
<script>
    var token = $("meta[name='csrf-token']").attr("content");
    var table = $('#myTable').DataTable({
        language: {
            search: "",
            "searchPlaceholder": "Search",
            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:var(--theme-orange-red);"></i>',
            paginate: {
                    next: 'Next', // 'Next' label for the next button
                    previous: 'Previous'
            }
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: admin_url + "bulk-product-file-list",
            type: 'post',
            data: {
                _token: token,
                refresh: false
            },
        },

        columns: [{
                data: 'ser_id',
                name: 'id',
                width: '1%'
            },
            {
                data: 'cat',
                name: 'cat',
                width: '10%',
                orderable: false,
                searchable: false
            },
            {
                data: 'file',
                name: 'file',
                width: '20%',
                orderable: false,
                searchable: false
            },
            {
                data: 'invalid_file',
                name: 'invalid_file',
                width: '20%',
                orderable: false,
                searchable: false
            },
            {
                data: 'status',
                name: 'status',
                width: '10%',
                orderable: false,
                searchable: false
            },
            {
                data: 'progress',
                name: 'progress',
                width: '10%',
                orderable: false,
                searchable: false
            },
            {
                data: 'publish',
                name: 'publish',
                width: '10%',
                orderable: false,
                searchable: false
            },
            {
                data: 'f_updated_at',
                name: 'f_updated_at',
                width: '19%',
                orderable: true,
                searchable: true
            },
        ],

        pagingType: 'simple_numbers',
        // dom: 'frtip',
        lengthMenu: [10, 50, 100, 250, 500],
        searching: false,
    });

    function refreshPendingRows() {
        var pendingRows = [];
        var data = table.rows().data();

        // Collect IDs of rows with 'Pending' status
        data.each(function(row) {
            if ($(row.status).text().trim() === 'Pending') {
                pendingRows.push(row.id);
            }
        });

        // Make AJAX call to get updated data for 'Pending' rows
        if (pendingRows.length > 0) {
            $.ajax({
                url: admin_url + "bulk-product-file-list",
                type: 'post',
                data: {
                    _token: token,
                    ids: pendingRows,
                    refresh: true
                },
                success: function(response) {
                    // Update DataTable rows with new data
                    response.data.forEach(function(updatedRow) {
                        table.rows().every(function() {
                            var row = this.node();
                            var rowData = this.data();
                            if (rowData.id === updatedRow.id) {
                                this.data(updatedRow).invalidate().draw(false);
                            }
                        });
                    });
                }
            });
        }
    }
    setInterval(refreshPendingRows, 2000);
    $(document).on("click",".publish_btn",function() {
        var file_id = $(this).data('id');
        setalert = 0;
        $.ajax({
            url: admin_url + "publish-product-file",
            type: "POST",
            data: {
                file_id: file_id,
                checkproduct: '1',
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            async: false,
            dataType: 'json',
            success: function(result) {
               // if(result.status) {
                    if(result.status == 0)
                    {
                        var setalert = 1;
                    }
                    if(setalert == 0){
                        var alertmessage = "You are about to Publish All Product Without Images!";
                    }else{
                        var alertmessage = "You are about to Publish All Product uploaded by this File!";
                    }
                // }
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: alertmessage,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Publish!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('.backend-loading').removeClass('d-none');
                            $.ajax({
                                url: admin_url + "publish-product-file",
                                type: "POST",
                                data: {
                                    file_id: file_id,
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                },
                                dataType: 'json',
                                success: function(result) {
                                    $('.backend-loading').addClass('d-none');
                                    if(result.status == 1) {
                                        toastr.success(result.message);
                                        $('#myTable').DataTable().ajax.reload();
                                    } else {
                                        toastr.error(result.message);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    $('.backend-loading').addClass('d-none');
                                    toastr.error('Something Went Wrong!');
                                }
                            });
                        }
                    });
            },
            error: function(xhr, status, error) {
                $('.backend-loading').addClass('d-none');
                toastr.error('Something Went Wrong!');
            }
        });
        
        
    });


</script>
@endsection
