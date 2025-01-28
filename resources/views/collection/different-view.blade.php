@extends('layouts.backend.index')
@section('main_content')

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('product_all.index')}}"> Inventory </a></li>
                    <li class="breadcum-item"><a href="{{route('collection.index')}}"> Collection</a></li>
                    <li class="breadcum-item active"><a href="javascript:;">Add Catalogue In Collection</a></li>
                </ul>
            </div>

            <div class="main-body">
                <div class="page-wrapper">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="">Add Catalogue in {{ isset($collection->name) ? $collection->name : '' }}</h3>
                        <a href="javascript:;" class="back-btn" id="add_product_cat">Add Selected Catalogues</a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-2 button_view list-view-left">
                        <p>*You can add multiple Catalogues</p>
                        <input type="hidden" name="collection_id" id="collection_id" value="{{ isset($collection->id) ? $collection->id : '' }}">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary sm chart_toggle active" id="list_lable">
                                <input type="radio" class="d-none" name="t_alignment" id="t_left" value="list">
                                <i class="fa fa-list"></i> List View
                            </label>
                            <label class="btn btn-primary sm chart_toggle" id="grid_lable">
                                <input type="radio" class="d-none" name="t_alignment" id="t_center" value="grid">
                                <i class="fa fa-th-large"></i> Grid View
                            </label>
                        </div>
                    </div>
                    <div class="input_group mt-3">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                    <label>Search <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please Search Catalogue Title"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                    <input type="text" name="name" id="search_value" class="form-control" placeholder="Search Catalogues">
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-sec pt-4">
                                    <button class="btn table-filter-btn mt-1" type="button" id="seach_filter">Search</button>
                                    <a class="btn" style="color: #DE5757; display: none;" id="clear_filter">X Clear Filter</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input_group mt-3">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-12 col-sm-12 col-xs-12">
                                    <label>Show Entries <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select count products" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                        <select name="show_count" class="form-control" id="show_count" required data-parsley-errors-container="#cat_error" data-parsley-required-message="Please Select Product Category">
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="combine_div">
                        <!-- @include('collection.combine-view') -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  

@endsection
@section('script')
<script>
    $('input[name="t_alignment"]').change(function () {
        var selected = $('input[name="t_alignment"]:checked').val();
        if(selected == 'grid')
        {
            $('#main_list').hide();
            $('#grid_main').show();
        }else{
            $('#grid_main').hide();
            $('#main_list').show();

        }
    });
    $( document ).ready(function() {
        var ids = [];
        @foreach($added_products as $product)
            ids.push('{{ $product }}');
        @endforeach
        function show_entries(show_count)
        {
            var collection_id = $('#collection_id').val();
            var text = $('#search_value').val();
            $('.check-icon-visible').each(function () {
                ids.push($(this).data('id'));
            });
            $.ajax({
                    url: '{{route('collection.show_count_cat')}}',
                    type: "POST",
                    data: {
                        show_count: show_count,
                        collection_id: collection_id,
                        text: text,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#combine_div').html('');
                        $('#combine_div').append(result.html);
                        var selected = $('input[name="t_alignment"]:checked').val();
                        if(selected == 'grid')
                        {
                            $('#main_list').hide();
                            $('#grid_main').show();
                            $('#list_lable').removeClass('active');
                            $('#grid_lable').addClass('active');
                        }else{
                            $('#grid_main').hide();
                            $('#main_list').show();
                            ('#list_lable').addClass('active');
                            $('#grid_lable').removeClass('active');
                        }
                    }
                });
        }
        var show_count = $('#show_count').val();
        show_entries(show_count);
        setTimeout(function () {
            $(".filter-pagination .count.common-btn").removeClass("active");
            $(".filter-pagination .count.common-btn:first").addClass("active");
        },500);
        $(document).on("click",".add_cat_pro",function() {
            var checkbox = $(this).find('.check-icon');
            var selected = $(this).find('.varified_img');
            checkbox.toggleClass("check-icon-visible");
            selected.toggleClass("selected");
            checkbox.prop('checked', !checkbox.prop('checked'));
            var dataId = parseInt(checkbox.data('id'));
            $('.add_cat_pro_list[data-id="' + dataId + '"]').toggleClass("check-icon-visible");
            // ids.push(dataId);
             if (checkbox.hasClass("check-icon-visible")) {
                if (!isNaN(dataId) && ids.indexOf(dataId.toString()) === -1) {
                    ids.push(dataId.toString()); // Add dataId to ids array if the class is added and it's a number
                }
            } else {
                    var index = ids.indexOf(dataId.toString());
                    if (index !== -1) {
                        ids.splice(index, 1); // Remove dataId from ids array if found
                    }
                }
        });
        $(document).on("click",".add_cat_pro_list",function() {
            var checkbox = $(this);
            checkbox.toggleClass("check-icon-visible");
            var dataId = checkbox.data('id');
            $('.check-icon[data-id="' + dataId + '"]').toggleClass("check-icon-visible");
            // ids.push(dataId);
             if (checkbox.hasClass("check-icon-visible")) {
                if (!isNaN(dataId) && ids.indexOf(dataId.toString()) === -1) {
                    ids.push(dataId.toString()); // Add dataId to ids array if the class is added and it's a number
                }
            } else {
                    var index = ids.indexOf(dataId.toString());
                    if (index !== -1) {
                        ids.splice(index, 1); // Remove dataId from ids array if found
                    }
                }
        });
        $(document).on("click","#select_all",function() {
            var selectAllCheckbox = $(this);
            var isChecked = selectAllCheckbox.prop('checked');
            $('.add_cat_pro_list').each(function () {
                $(this).prop('checked', isChecked);
                var dataId = $(this).data('id');
                $(this).toggleClass('check-icon-visible', isChecked);
                $('.check-icon[data-id="' + dataId + '"]').toggleClass("check-icon-visible", isChecked);
                if (isChecked) {
                    if (!isNaN(dataId) && ids.indexOf(dataId.toString()) === -1) {
                        ids.push(dataId.toString()); // Add dataId to ids array if the class is added and it's a number
                    }
                } else {
                    var index = ids.indexOf(dataId.toString());
                    if (index !== -1) {
                        ids.splice(index, 1); // Remove dataId from ids array if found
                    }
                }
            });
            $('.check-icon').each(function () {
                $(this).toggleClass('check-icon-visible', isChecked);
                var dataId = $(this).data('id');
                $('.check-icon[data-id="' + dataId + '"]').toggleClass("check-icon-visible", isChecked);
                if (isChecked) {
                    if (!isNaN(dataId) && ids.indexOf(dataId.toString()) === -1) {
                        ids.push(dataId.toString()); // Add dataId to ids array if the class is added and it's a number
                    }
                } else {
                    var index = ids.indexOf(dataId.toString());
                    if (index !== -1) {
                        ids.splice(index, 1); // Remove dataId from ids array if found
                    }
                }
            });
        });
        $(document).on("click","#add_product_cat",function() {
            // $('.check-icon-visible').each(function () {
            //     ids.push($(this).data('id'));
            // });
            var collection_id = $('#collection_id').val();
                $.ajax({
                url: '{{ route('add.catalogue.collection') }}',
                type: "POST",
                data: {
                  ids: ids,
                  collection_id: collection_id,
                  _token: $('meta[name="csrf-token"]').attr('content'),
              },
              dataType: 'json',
                  success: function(result) {
                    if(result.status == 1)
                    {
                        var selected = $('input[name="t_alignment"]:checked').val();
                        if(selected == 'grid')
                        {
                            $('#list_lable').removeClass('active');
                            $('#grid_lable').addClass('active');
                        }else{
                            $('#list_lable').addClass('active');
                            $('#grid_lable').removeClass('active');
                        }
                        var show_count = $('#show_count').val();
                        show_entries(show_count);
                        setTimeout(function () {
                            $(".filter-pagination .count.common-btn").removeClass("active");
                            $(".filter-pagination .count.common-btn:first").addClass("active");
                        },500);
                        toastr.success(result.message);
                    }else{
                        toastr.error(result.message);
                    }
                }
            });   
        });
        $(document).on("click","#seach_filter",function() {
            $('.check-icon-visible').each(function () {
                ids.push($(this).data('id'));
            });
            var text = $('#search_value').val();
            var collection_id = $('#collection_id').val();
            if(text && text != null && text != '')
            {
                $.ajax({
                    url: '{{ route('search.catalogue.collection') }}',
                    type: "POST",
                    data: {
                      text: text,
                      collection_id: collection_id,
                      _token: $('meta[name="csrf-token"]').attr('content'),
                  },
                  dataType: 'json',
                  success: function(result) {
                    if(result.status == 1)
                    {
                        $('#combine_div').html(result.html);
                        $('#clear_filter').show();
                        var selected = $('input[name="t_alignment"]:checked').val();
                        if(selected == 'grid')
                        {
                            $('#main_list').hide();
                            $('#grid_main').show();
                        }else{
                            $('#grid_main').hide();
                            $('#main_list').show();
                        }
                    }else{
                        toastr.error('Something Went Wrong!');
                        $('#clear_filter').hide();
                    }
                }
            }); 
            }else{
                toastr.error('Please Enter text in Search holder!');
            }
        });

        $(document).on("click","#clear_filter",function() {
            // $('#combine_div').load(' #combine_div');
            $('#search_value').val('');
            var selected = $('input[name="t_alignment"]:checked').val();
            if(selected == 'grid')
            {
                $('#list_lable').removeClass('active');
                $('#grid_lable').addClass('active');
            }else{
                $('#list_lable').addClass('active');
                $('#grid_lable').removeClass('active');
            }
            
            show_entries(show_count);
            setTimeout(function () {
                $(".filter-pagination .count.common-btn").removeClass("active");
                $(".filter-pagination .count.common-btn:first").addClass("active");
            },500);
            $(this).hide();
        });
        $(document).on("change","#show_count",function() {
            var show_count = $(this).val();
            $('.check-icon-visible').each(function () {
                ids.push($(this).data('id'));
            });
            show_entries(show_count);
            setTimeout(function () {
                $(".filter-pagination .count.common-btn").removeClass("active");
                $(".filter-pagination .count.common-btn:first").addClass("active");
            },500);
        });
        $(document).on('click','.common-btn', function() {
           var start = $(this).data('start');
           var end = $(this).data('end');
           var text = $('#search_value').val();
            var show_count = $('#show_count').val();
            var collection_id = $('#collection_id').val();
            $('.check-icon-visible').each(function () {
                ids.push($(this).data('id'));
            });
           $.ajax({
              type: 'POST', 
              url: '{{route('page.catalogue.collection')}}', 
              data: {
                 start: start,
                 end: end,
                 text: text,
                 show_count: show_count,
                 collection_id: collection_id,
              },
              success: function(response) {
                $('#combine_div').html(response.html);
                var selected = $('input[name="t_alignment"]:checked').val();
                if(selected == 'grid')
                {
                    $('#main_list').hide();
                    $('#grid_main').show();
                }else{
                    $('#grid_main').hide();
                    $('#main_list').show();
                }
             },
             error: function(error) {
                toastr.error('Something Went Wrong!');
             }
          });
        });

});
</script>


@endsection
