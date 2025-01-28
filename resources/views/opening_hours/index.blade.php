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
                                        <h5>Opening Hours</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                                            <form id="addtags" action="{{ route('opening_hours.save') }}" method="POST"
                                                data-parsley-validate="">
                                                @csrf
                                                <input type="hidden" id="direction_link_id" value="" name="direction_link_id">
                                                <div class="input_group">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Monday</label>
                                                    <div class="row">
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <input class="form-control" id="monday_form" name="monday_form" type="time" value="{{isset($opening_hours[0]->from) ? $opening_hours[0]->from : ''}}" placeholder="From">
                                                        </div>
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <input class="form-control" id="monday_to" name="monday_to" type="time" value="{{isset($opening_hours[0]->to) ? $opening_hours[0]->to : ''}}" placeholder="To">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Tuesday</label>
                                                    <div class="row">
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <input class="form-control" id="tuesday_form" name="tuesday_form" type="time" value="{{isset($opening_hours[1]->from) ? $opening_hours[1]->from : ''}}" placeholder="From">
                                                        </div>
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <input class="form-control" id="tuesday_to" name="tuesday_to" type="time" value="{{isset($opening_hours[1]->to) ? $opening_hours[1]->to : ''}}" placeholder="To">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Wednesday</label>
                                                    <div class="row">
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <input class="form-control" id="wednesday_form" name="wednesday_form" type="time" value="{{isset($opening_hours[2]->from) ? $opening_hours[2]->from : ''}}" placeholder="From">
                                                        </div>
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <input class="form-control" id="wednesday_to" name="wednesday_to" type="time" value="{{isset($opening_hours[2]->to) ? $opening_hours[2]->to : ''}}" placeholder="To">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Thursday</label>
                                                    <div class="row">
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <input class="form-control" id="thursday_form" name="thursday_form" type="time" value="{{isset($opening_hours[3]->from) ? $opening_hours[3]->from : ''}}" placeholder="From">
                                                        </div>
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <input class="form-control" id="thursday_to" name="thursday_to" type="time" value="{{isset($opening_hours[3]->to) ? $opening_hours[3]->to : ''}}" placeholder="To">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Friday</label>
                                                    <div class="row">
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <input class="form-control" id="friday_form" name="friday_form" type="time" value="{{isset($opening_hours[4]->from) ? $opening_hours[4]->from : ''}}" placeholder="From">
                                                        </div>
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <input class="form-control" id="friday_to" name="friday_to" type="time" value="{{isset($opening_hours[4]->to) ? $opening_hours[4]->to : ''}}" placeholder="To">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Saturday</label>
                                                    <div class="row">
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <input class="form-control" id="saturday_form" name="saturday_form" type="time" value="{{isset($opening_hours[5]->from) ? $opening_hours[5]->from : ''}}" placeholder="From">
                                                        </div>
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <input class="form-control" id="saturday_to" name="saturday_to" type="time" value="{{isset($opening_hours[5]->to) ? $opening_hours[5]->to : ''}}" placeholder="To">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Sunday</label>
                                                    <div class="row">
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <input class="form-control" id="sunday_form" name="sunday_form" type="time" value="{{isset($opening_hours[6]->from) ? $opening_hours[6]->from : ''}}" placeholder="From">
                                                        </div>
                                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <input class="form-control" id="sunday_to" name="sunday_to" type="time" value="{{isset($opening_hours[6]->to) ? $opening_hours[6]->to : ''}}" placeholder="To">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-lg btn-primary">Save</button>
                                                   <!--  <button type="button" id="tags_clear" name="clear"
                                                        class="btn btn-lg btn-danger">Clear</button> -->
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
                                        <h5>Opening Hours</h5>
                                    </div>
                                    <div class="card-body card-block px-0 py-3">
                                        <div class="table-responsive" role="tabpanel" id="">
                                            <table class="table table-hover" id="tags_table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Day</th>
                                                        <th scope="col">Time</th>
                                                        <th scope="col">Open/Close</th>
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
                        next: 'Next', // 'Next' label for the next button
                        previous: 'Previous'
                }
                },
                processing: true,
                bAutoWidth: false,
                aoColumns: [{
                        sWidth: '10%'
                    },
                    {
                        sWidth: '30%'
                    },
                    {
                        sWidth: '30%'
                    },
                    {
                        sWidth: '30%'
                    }
                ],
                ajax: {
                    url: admin_url + "opening-hours/list",
                    type: 'post',
                    data: {
                        _token: token,
                    },
                },

                columns: [{
                        data: 'ser_id',
                        name: 'id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'day',
                        name: 'Day',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'time',
                        name: 'time',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
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
                    url: admin_url + "check/featured-hours",
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
