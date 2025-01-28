@extends('layouts.backend.index')
@section('main_content')
<style>
.add-article .card-block label img{
  width: 35px;
  height: 35px;
  border-radius: 50%;
}
</style>
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('accesscontrole.dash_index')}}">Access Control</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Registration form </a></li>
                </ul>
            </div>
            <div class="main-body">
                <div class="page-wrapper">
                        <div class="row">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                                <div class="Recent-Users">
                                    <div class="d-flex justify-content-between">
                                        <h5>Registration form Settings</h5>
                                        <!-- <button type="submit" class="btn btn-lg btn-primary" id="submit_form">Update Settings</button> -->
                                    </div>
                                    <div class="card-block px-0 py-3 home_page">
                                        <div class="row">
                                            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 section-list">
                                                @if(isset($rs) && count($rs) > 0)
                                                @foreach($rs as $key => $item)
                                                <div class="each_sec">
                                                    <div class="main_sec" >
                                                        <label for="">{{ isset($item->title) ? $item->title : '' }}</label>
                                                        <div style="min-width:150px">
                                                            <label>Display</label>
                                                            <label class="switch mb-0">
                                                                <input type="checkbox" class="slidersecbutton" name="display_checked" data-type="display" data-id="{{ isset($item->id) ? $item->id : '' }}" @if(isset($item->display) && $item->display == 1) checked @endif>
                                                                <div class="slider round">
                                                                    <span class="on">Yes</span>
                                                                    <span class="off">No</span>
                                                                </div>
                                                            </label>
                                                        </div>   
                                                        <div style="min-width:150px">
                                                            <label>Mandatory</label>
                                                            <label class="switch mb-0">
                                                                <input type="checkbox" class="slidersecbutton" name="mandatory_checked" data-type="mandatory" data-id="{{ isset($item->id) ? $item->id : '' }}" @if(isset($item->mandatory) && $item->mandatory == 1) checked @endif>
                                                                <div class="slider round">
                                                                    <span class="on">Yes</span>
                                                                    <span class="off">No</span>
                                                                </div>
                                                            </label>
                                                        </div> 
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
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
$(document).on('click', '.slidersecbutton', function() {
    var token = $("meta[name='csrf-token']").attr("content");
    var id = $(this).attr("data-id");
    var isChecked = $(this).is(':checked');
    var type = $(this).attr('data-type');
    var title = '';
    var label = '';
    if(type == 'display')
    {
        if(isChecked == true)
        {
            var title = 'Display';
        }else{
            var title = 'Hide';
        }
        var label = 'You are about to Display/Hide this field!';
    }else{
        if(isChecked == true)
        {
            var title = 'Mandatory';
        }else{
            var title = 'Optional';
        }
        var label = 'You are about to Mandatory/Optional this field!';
    }  
    Swal.fire({
        title: 'Are you sure?',
        text: label,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, '+title+'!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed == true) {
            $.ajax({
                url: admin_url + "update-fields-status",
                type: "post",
                data: {
                    _token: token,
                    isChecked: isChecked,
                    type: type,
                    id: id,
                },
                success: function(data) {
                    if (data.status == 1) {
                        if(isChecked == false)
                        {
                            var checkbox = $('input.slidersecbutton[data-id="' + id + '"]');
                            checkbox.prop('checked', false);
                        }   
                        toastr.success(data.message);
                    } else if (data.status == 0) {
                        toastr.error(data.message);
                    }
                }
            });
        }else{
            window.location = '{{ route('registration.setting.index') }}';
        }
    });
});
 </script>
@endsection
