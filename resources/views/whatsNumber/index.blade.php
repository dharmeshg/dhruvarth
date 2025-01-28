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
                                    <h5>Whats Number</h5>
                                </div>
                                <div class="card-body">

                                    <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                                        <form id="addcategory" action="{{ route('whatsNumber.save') }}" method="POST"
                                            data-parsley-validate="">
                                            @csrf
                                            <div class="input_group">
                                            <input type="hidden" id="number_id" name="number_id" value="{{isset($phone_number->id) ? $phone_number->id : ''}}">
                                            <div class="form-group"><label class="form-label" for="exampleFormControlInput1">Number</label></div>
                                            <div class="form-group">
                                                    <input type="text" id="mobile_code" class="form-control imput-mask" value="{{isset($phone_number->number) ? $phone_number->number : ''}}"  placeholder="Phone Number" name="number">
                                                    <input type="hidden" id="country_code" name="country_code" value="{{ isset($phone_number->country_code) ? $phone_number->country_code : 'in' }}">
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
                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                <h5>Whats Number</h5>
                                </div>
                                <div class="card-body card-block px-0 py-3">
                                    <div class="table-responsive" role="tabpanel" id="">
                                        <table class="table table-hover" id="myTable" style="width:100%">
                                            <thead>
                                                <tr class="unread">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Number</th>
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
        var mobileCode = $("#mobile_code").intlTelInput({
                        initialCountry: "{{ isset($phone_number->country_code) ? $phone_number->country_code : 'in' }}",
                        separateDialCode: true,

                 
      });

            mobileCode.on("countrychange", function (e) {
                var selectedCountryData = mobileCode.intlTelInput('getSelectedCountryData');
            $("#country_code").val(selectedCountryData.iso2);
        });   
   
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
                    sWidth: '99%'
                }
            ],
            ajax: {
                url: admin_url + "whatsNumber/list",
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
                    data: 'number',
                    name: 'Number',
                    orderable: false,
                    searchable: false
                },
          
            ],
            pagingType: 'simple_numbers',
        });


    });
    </script>


    @endsection