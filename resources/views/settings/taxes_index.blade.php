@extends('layouts.backend.index')
@section('main_content')
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('setting_all.index')}}"> Settings </a></li>
                    <li class="breadcum-item"><a href="{{route('global_settings.index')}}">Global Settings</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Taxation</a></li>
                </ul>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- [ Main Content ] start -->
                    <form action="{{ route('setting.taxes.save') }}" method="POST" data-parsley-validate=""
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                            <div class="Recent-Users">
                                <h5>Taxation</h5>
                                <div class="card-block px-0 py-3">
                                    <div class="row">
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                <label for="">National Tax (%) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter national tax"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                <input type="number" class="form-control" name="p_national_tax" id="p_national_tax" placeholder="Enter National Tax (%)" value="{{ isset($setting->national_tax) ? $setting->national_tax : ''}}">
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                <label for="">Minimum Amount <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter minimum amount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                <input type="number" class="form-control" name="p_above_amount" id="p_above_amount" placeholder="Enter Minimum Amount" value="{{ isset($setting->nation_above_amount) ? $setting->nation_above_amount : '0'}}">
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-sec add-product-step-form-sec">
                                                <label for="">International Tax (%) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter international tax details"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                <div class="table-responsive international-tax-table">
                                                    <table class="table table-bordered table-fixed">
                                                        <thead>
                                                            <tr>
                                                              <th>Country</th>
                                                              <th>Tax (%)</th>
                                                              <th>Above Amount</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                        @if(isset($setting->taxes) && $setting->taxes != '' && $setting->taxes != null)
                                                        @php
                                                        $contry_json = json_decode($setting->taxes);
                                                        $p_tax_contry_values = is_array($contry_json) ? array_column($contry_json, 'p_tax_contry') : [];
                                                        $p_tax_contry_tax_values = is_array($contry_json) ? array_column($contry_json, 'p_int_tax') : [];
                                                        $p_tax_contry_above_values = is_array($contry_json) ? array_column($contry_json, 'p_int_above') : [];
                                                        @endphp
                                                        @endif
                                                        @if(isset($countries) && count($countries) > 0)
                                                        <tr>
                                                          <td> <label class="checkbox-inline">
                                                            <input type="checkbox" value="all" name="p_tax_contry[]" class="contry_check" @if(isset($p_tax_contry_values) && in_array("all",$p_tax_contry_values)) checked @endif >All
                                                        </label></td>
                                                        <td><input type="number" class="form-control int_tax" id="" placeholder="" @if(isset($p_tax_contry_values) && in_array("all",$p_tax_contry_values)) value="{{ $p_tax_contry_tax_values[array_search('all', $p_tax_contry_values)] }}" name="p_int_tax[]" @endif></td>
                                                        <td><input type="number" class="form-control int_above"  id="" placeholder="" @if(isset($p_tax_contry_values) && in_array("all",$p_tax_contry_values)) value="{{ $p_tax_contry_above_values[array_search('all', $p_tax_contry_values)] }}" name="p_int_above[]" @endif></td>
                                                    </tr>  
                                                    @foreach($countries as $country)
                                                    <tr>
                                                      <td> <label class="checkbox-inline">
                                                        <input type="checkbox" value="{{ isset($country->id) ? $country->id : ''}}" name="p_tax_contry[]" class="contry_check" @if(isset($p_tax_contry_values) && in_array($country->id,$p_tax_contry_values)) checked @endif >{{ isset($country->name) ? $country->name : '' }}
                                                    </label></td>
                                                    <td><input type="number" class="form-control int_tax" id="" placeholder="" @if(isset($p_tax_contry_values) && in_array($country->id,$p_tax_contry_values)) value="{{ $p_tax_contry_tax_values[array_search($country->id, $p_tax_contry_values)] }}" name="p_int_tax[]" @endif></td>
                                                    <td><input type="number" class="form-control int_above"  id="" placeholder="" @if(isset($p_tax_contry_values) && in_array($country->id,$p_tax_contry_values)) value="{{ $p_tax_contry_above_values[array_search($country->id, $p_tax_contry_values)] }}" name="p_int_above[]" @endif></td>
                                                </tr>  
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-sec mt-4">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                            <button type="submit" id="submit_form" class="common-sub-btn">Save</button>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </form>
    <!-- [ Main Content ] end -->
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
    $(document).on('click', '.contry_check', function(){
        if($(this).prop('checked')){
            $(this).closest('tr').find('.int_tax').attr('name', 'p_int_tax[]');
            $(this).closest('tr').find('.int_above').attr('name', 'p_int_above[]');
        }else {
            $(this).closest('tr').find('.int_tax').removeAttr('name');
            $(this).closest('tr').find('.int_above').removeAttr('name');
        }
    });
</script>
@endsection
