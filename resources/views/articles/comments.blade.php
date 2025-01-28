@extends('layouts.backend.index')
@section('main_content')
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->

                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row ">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card Recent-Users mb-4">
                                    <div class="card-header">
                                        <h5>Comments</h5>
                                        <div class="btn-group dashboard_chart" data-toggle="buttons">
                                                <label class="btn btn-primary sm chart_toggle active">
                                                    <input type="radio" class="d-none" name="t_alignment" id="t_left" value="approved">
                                                    Approved
                                                </label>
                                                <label class="btn btn-primary sm chart_toggle">
                                                    <input type="radio" class="d-none" name="t_alignment" id="t_center" value="not_approved">
                                                    Not Approved
                                                </label>
                                                <label class="btn btn-primary sm chart_toggle">
                                                    <input type="radio" class="d-none" name="t_alignment" id="t_center" value="spam">
                                                    Spam
                                                </label>
                                                <label class="btn btn-primary sm chart_toggle">
                                                    <input type="radio" class="d-none" name="t_alignment" id="t_center" value="trashed">
                                                    Trashed
                                                </label>
                                            </div>
                                    </div>
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive" role="tabpanel" id="">
                                            <table class="table table-hover" id="commentsTable" style="width:100%">
                                                <thead>
                                                    <tr class="unread">
                                                        <th scope="col">#</th>
                                                        <th scope="col">Author</th>
                                                        <th scope="col">Comment</th>
                                                        <th scope="col">In Response To</th>
                                                        <th scope="col">Submitted On</th>
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
                function getData(selected)
                {
                    if ($.fn.DataTable.isDataTable('#commentsTable')) {
                        $('#commentsTable').DataTable().destroy();
                    }

                    var token = $("meta[name='csrf-token']").attr("content");
                    var table = $('#commentsTable').DataTable({
                        language: {
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
                                targets: [0, 4],
                                orderable: false,
                            },
                            { width: "5%", targets: 0 },
                            { width: "30%", targets: 1 },
                            { width: "25%", targets: 2 },
                            { width: "25%", targets: 3 },
                            { width: "10%", targets: 3 },
                        ],
                        ajax: {
                            url: admin_url + "comments-list",
                            type: 'post',
                            data: {
                                _token: token,
                                selected : selected

                            },
                        },
                        columns: [{
                                data: 'ser_id',
                                name: 'id'
                            },
                            {
                                data: 'author',
                                name: 'author'
                            },
                            {
                                data: 'comment',
                                name: 'comment'
                            },
                            {
                                data: 'response',
                                name: 'response'
                            },
                            {
                                data: 'submit',
                                name: 'submit'
                            },
                            
                        ]
                    });
                    }
                $(document).ready(function() {
                    var selected = $('#t_left').val();
                    getData(selected);
                });
                 $('input[name="t_alignment"]').change(function () {
                    var selected = $('input[name="t_alignment"]:checked').val();
                    getData(selected);
                }); 
                    
                    

                    

                    $(document).on('click', '.change_status', function() {
                        var token = $("meta[name='csrf-token']").attr("content");
                        var id = $(this).attr("data-id");
                        var status = $(this).attr('data-status');
                        var val = $(this).attr('data-val');
                        $.ajax({
                            url: admin_url + "comments-status-change",
                            type: "post",
                            data: {
                                _token: token,
                                status: status,
                                val: val,
                                id: id,
                            },
                            success: function(data) {
                                if (data.status == 1) {
                                    toastr.success(data.message);
                                    $('#commentsTable').DataTable().ajax.reload();
                                } else if (data.status == 2) {
                                    toastr.error(data.message);
                                    $('#commentsTable').DataTable().ajax.reload();
                                } else if (data.status == 3)
                                {
                                    toastr.error(data.message);
                                }

                            }
                        });
                    })
                

                
            </script>
        @endsection
