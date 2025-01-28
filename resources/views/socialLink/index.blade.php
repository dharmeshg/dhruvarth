@extends('layouts.backend.index')
@section('main_content')

<style>
.form-group .iti--allow-dropdown{
    width: 100%;
}
.form-group #mobile_code{
    padding-left: 82px !important;
}
</style>
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
                                    <h5>Social Link</h5>
                                </div>
                                <div class="card-body">

                                    <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                                        <form id="addcategory" action="{{ route('socialLink.save') }}" method="POST"
                                        data-parsley-validate="">
                                        @csrf
                                        <!-- <input type="hidden" id="link_id" name="link_id" value="{{isset($link->id) ? $link->id : ''}}"> -->

                                    <div class="input-group mb-3">
                                         <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fab fa-dribbble fa-2x" style="color: #ec4a89;"></i></span>
                                        </div>
                                        <input type="url" id="website_url" class="form-control" value="{{isset($link[0]->url) ? $link[0]->url : ''}}"  placeholder="Website Url" name="website_url">

                                    </div>
                                     <div class="input-group mb-3">
                                         <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fab fa-facebook-f fa-2x" style="color: #3b5998;"></i></span>
                                        </div>
                                        <input type="url" id="facebook" class="form-control" value="{{isset($link[1]->url) ? $link[1]->url : ''}}"  placeholder="Facebook" name="facebook">

                                    </div>
                                     <div class="input-group mb-3">
                                         <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fab fa-linkedin-in fa-2x" style="color: #0082ca;"></i></span>
                                        </div>
                                        <input type="url" id="linkedin" class="form-control" value="{{isset($link[2]->url) ? $link[2]->url : ''}}"  placeholder="Linkedin" name="linkedin">

                                    </div>
                                     <div class="input-group mb-3">
                                         <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fab fa-pinterest fa-2x" style="color: #c61118;"></i></span>
                                        </div>
                                        <input type="url" id="pinterest" class="form-control" value="{{isset($link[3]->url) ? $link[3]->url : ''}}"  placeholder="Pinterest" name="pinterest">

                                    </div>
                                     <div class="input-group mb-3">
                                         <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fab fa-twitter fa-2x" style="color: #55acee;"></i></span>
                                        </div>
                                        <input type="url" id="twitter" class="form-control" value="{{isset($link[4]->url) ? $link[4]->url : ''}}"  placeholder="Twitter" name="twitter">

                                    </div>
                                     <div class="input-group mb-3">
                                         <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fab fa-instagram fa-2x" style="color: #ac2bac;"></i></span>
                                        </div>
                                        <input type="url" id="instagram" class="form-control" value="{{isset($link[5]->url) ? $link[5]->url : ''}}"  placeholder="Instagram" name="instagram">

                                    </div>
                                     <div class="input-group mb-3">
                                         <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fab fa-youtube fa-2x" style="color: #ed302f;"></i></span>
                                        </div>
                                        <input type="url" id="youtube" class="form-control" value="{{isset($link[6]->url) ? $link[6]->url : ''}}"  placeholder="Youtube" name="youtube">

                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-lg btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="card Recent-Users mb-4">
                        <div class="card-header">
                            <h5>Social Link</h5>
                        </div>
                        <div class="card-body card-block px-0 py-3">
                            <div class="table-responsive" role="tabpanel" id="">
                                <table class="table table-hover" id="myTable" style="width:100%">
                                    <thead>
                                        <tr class="unread">
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Url</th>
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


</script>

<script>
    $(document).ready(function() {
        var token = $("meta[name='csrf-token']").attr("content");

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
                sWidth: '20%'
            },
            {
                sWidth: '79%'
            }
            ],
            ajax: {
                url: admin_url + "social-link/list",
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
                data: 'name',
                name: 'name',
                orderable: false,
                searchable: false
            },
            {
                data: 'url',
                name: 'url',
                orderable: false,
                searchable: false
            }

            ],
            pagingType: 'simple_numbers',
        });


    });
</script>


@endsection