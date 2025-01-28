@extends('layouts.backend.index')
@section('main_content')

<!-- <div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">

            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <h5>Add New Metal Rate</h5>
                                </div>
                                <div class="card-body">

                                    <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                                        <form id="addcategory" action="{{ route('metalrate.save') }}" method="POST"
                                            data-parsley-validate="">
                                            @csrf
                                            <input type="hidden" id="rate_id" name="rate_id">
                                            <div class="input_group">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlTextarea1">Purity</label>
                                                <select class="form-select" id="purity" name="purity"
                                                    aria-label="Default select example" required
                                                    data-parsley-required-message="Please Choose Purity">
                                                    @if(isset($purities))
                                               
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">Rate (Price Per Gram)</label>
                                                <input class="form-control" id="rate" name="rate" type="number" required
                                                    data-parsley-required-message="Please Enter Name"
                                                    placeholder="Category Name">
                                                <span id="error_name" style="color:red;display:none;">This Name is
                                                    Already
                                                    Taken</span>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-lg btn-primary">Save</button>
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
                                <h5>Metal Rate List</h5>
                                </div>
                                <div class="card-body card-block px-0 py-3">
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Purity</th>
                                                    <th scope="col">Rate</th>
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
    </div> -->


    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card Recent-Users mb-4">
                                    <div class="card-header">
                                        <h5>Metal Rate</h5>
                                        <!-- <a href="{{route('promo_code.add')}}" class="add-article-btn">Metal Rate</a> -->
                                        <a href="" class="add-article-btn" data-bs-toggle="modal" data-bs-target="#metal_rate_modal">Metal Rate</a>
                                    </div>
                                    <div class="card-body card-block px-0 py-3">
                                        <div class="table-responsive" role="tabpanel" id="">
                                            <table class="table table-hover" id="myTable" style="width:100%">
                                                <thead>
                                                    <tr class="unread">
                                                        <th scope="col">#</th>
                                                        <th scope="col">Purity</th>
                                                        <th scope="col">Rate</th>
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

    <div class="modal fade" id="metal_rate_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Add Metal Rate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add_metal_rate" action="" method="" data-parsley-validate="" onsubmit="return false">
                        @csrf
                        <input type="hidden" id="rate_id" name="rate_id">
                        <div class="input_group">
                            <div class="mb-3">
                                <label class="form-label" for="exampleFormControlTextarea1">Purity</label>
                                <select class="form-select" id="purity" name="purity"
                                aria-label="Default select example" required
                                data-parsley-required-message="Please Choose Purity">
                                    @if(isset($purities))
                                    @foreach($purities as $purity)
                                        <option value="{{$purity->id}}">{{$purity->title}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="exampleFormControlInput1">Rate (Price Per Gram)</label>
                                <input class="form-control" oninput="validateAmount(this)" id="rate" name="rate" type="text" required
                                data-parsley-required-message="Please Enter Rate"
                                placeholder="Metal Rate">

                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-lg btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('script')

<script>
    $(document).ready(function() {
        var token = $("meta[name='csrf-token']").attr("content");

        var metal_table = $('#myTable').DataTable({
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
                url: admin_url + "metal-rate/list",
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
                data: 'metal_purity.title',
                name: 'metal_purity.title'
            },
            {
                data: 'rate',
                name: 'rate'
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


        $("#add_metal_rate").submit(function(e) {

          var data = new FormData($('#add_metal_rate')[0]);

          $.ajax({
            url: '{{ route('metalrate.save') }}',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: data,
            success: function (data) {
                if ((data.status = 1)) {
                    $("#metal_rate_modal").modal("toggle");
                    $("#metal_rate_modal form")[0].reset();
                    metal_table.ajax.reload();

                    if (data.status == 1) {
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }

                }
            },
        });

      });


        $("#metal_rate_modal").on("hidden.bs.modal", function () {
            $(this).find("form").trigger("reset");
            // $('#add_metal_rate').parsley('reset');
            $('#add_metal_rate').parsley().reset();
            $("#rate_id").val("");
            $("#modalCenterTitle").html("Add Metal Rate");
        });


        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var token = $("meta[name='csrf-token']").attr("content");
            var id = $(this).attr("data-id");
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete the Metal Rate!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: "{{ route('metalrate.delete') }}",
                    type: "post",
                    data: {
                        _token: token,
                        id: id,
                    },
                    success: function (data) {
                        metal_table.ajax.reload();
                    },
                });
              }
          });
        });


    });
</script>
<script>
   function validateAmount(inputField) {
    inputField.value = inputField.value.replace(/[^0-9.]/g, '');

    let decimalCount = (inputField.value.match(/\./g) || []).length;
    if (decimalCount > 1) {
        inputField.value = inputField.value.slice(0, -1);
    }
}
</script>

<script>


    $(document).on("click", ".edit", function() {
        $("#metal_rate_modal").modal("show");
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        $.ajax({
            url: admin_url + "metal-rate/edit",
            type: "post",
            data: {
                _token: token,
                id: id,
            },
            success: function(data) {
                var data = JSON.parse(data);
                var category_list = data.categories;
                $("#rate_id").val(data.id);
                $("#purity").val(data.purity);
                $("#rate").val(data.rate);

                $("#modalCenterTitle").html("Edit Metal Rate");
            },
        });
    });
    $(document).on("click", "#clear", function() {
        $("#rate_id").val("");
        $("#purity").val("");
        $("#rate").val("");
        $("#modalCenterTitle").html("Add Metal Rate");
    });

    $(document).on('click', '#is_featured', function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        var isChecked = $(this).is(':checked');
        $.ajax({
            url: admin_url + "metal-rate/pinned",
            type: "post",
            data: {
                _token: token,
                isChecked: isChecked,
                id: id,
            },
            success: function(data) {
                if (data.pinned == 2) {
                    toastr.success(data.message);
                } else if (data.pinned == 1) {
                    toastr.success(data.message);
                }else if(data.pinned == 3){
                    toastr.error(data.message);
                }

            }
        });
    })

    $(document).on('click', '#is_status', function() {
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        var isChecked = $(this).is(':checked');
        $.ajax({
            url: admin_url + "metal-rate/is_status",
            type: "post",
            data: {
                _token: token,
                isChecked: isChecked,
                id: id,
            },
            success: function(data) {
                if (data.status == 1) {
                    toastr.success(data.message);
                }else{
                    toastr.error(data.message);
                }

            }
        });
    })
</script>
@endsection