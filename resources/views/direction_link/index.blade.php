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
                                        <h5>Direction Link</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                                            <form id="addtags" action="{{ route('direction_link.save') }}" method="POST"
                                                data-parsley-validate="">
                                                @csrf
                                                <input type="hidden" id="direction_link_id" value="{{isset($direction_link->id) ? $direction_link->id : ''}}" name="direction_link_id">
                                                <div class="input_group">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleFormControlInput1">Link</label>
                                                    <input class="form-control" id="link" name="link" type="url" value="{{isset($direction_link->link) ? $direction_link->link : ''}}" 
                                                        required data-parsley-required-message="Please Enter Link"
                                                        placeholder="Please Enter Link">
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
                                        <h5>Direction Link</h5>
                                    </div>
                                    <div class="card-body card-block px-0 py-3">
                                        <div class="table-responsive" role="tabpanel" id="">
                                            <table class="table table-hover" id="tags_table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Link</th>
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
                        sWidth: '90%'
                    }
                ],
                ajax: {
                    url: admin_url + "direction-link/list",
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
                        data: 'link',
                        name: 'Link',
                        orderable: false,
                        searchable: false
                    }
                ],
                    pagingType: 'simple_numbers',
            });


        })
    </script>
   
@endsection
