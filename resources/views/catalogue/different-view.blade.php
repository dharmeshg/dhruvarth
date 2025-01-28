@extends('layouts.backend.index')
@section('main_content')
<style>
    #suggested_tags{
        position: absolute;
        z-index: 1;
        background-color: #fff;
        width: 238px;
        min-height: 0px;
        max-height: 250px;
        overflow-y: auto;
        list-style: none;
        color: #000;
    }
    .suggested_tags.active{border: 1px solid #aaa;}
    #suggested_tags li{    cursor: pointer;
    padding: 4px 6px;
    font-size: 15px;}
    #suggested_tags li:hover{background-color: #e0b667;}
</style>
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('product_all.index')}}"> Inventory </a></li>
                    <li class="breadcum-item"><a href="{{route('catalogue.index')}}"> Catalogue</a></li>
                    <li class="breadcum-item active"><a href="javascript:;">Add Product In Catalogue</a></li>
                </ul>
            </div>

            <div class="main-body">
                <div class="page-wrapper">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="">Add Products in {{ isset($catalogue->name) ? $catalogue->name : '' }}</h3>
                        <a href="javascript:;" class="back-btn" id="add_product_cat">Add Selected Products</a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-2 button_view list-view-left">
                        <p>*You can add multiple products</p>
                        <input type="hidden" name="catalogue_id" id="catalogue_id" value="{{ isset($catalogue->id) ? $catalogue->id : '' }}">
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
                                    <label>Search <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please search Product Title" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                    <input type="text" name="name" id="search_value" class="form-control" placeholder="Search Products By Name Or SKU">
                                </div>
                                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                <label for="">Product Category <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select product category"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                    <select name="p_category" class="form-control" id="all_cats" required data-parsley-errors-container="#cat_error" data-parsley-required-message="Please Select Product Category">
                                        <option disabled selected>Select Category</option>
                                        @if(isset($categories) && count($categories) > 0)
                                        @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ isset($product->p_category) && $product->p_category == $cat->id ? 'selected' : '' }}>{{ isset($cat->category) ? $cat->category : '' }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <span id="cat_error"></span>
                                </div>
                                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                <label for="">Product Family <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select product family"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                <select name="p_family" class="form-control" id="all_families" required data-parsley-errors-container="#fami_error" data-parsley-error-message="Product Family is required">
                                                    <option>Select Family</option>
                                                </select>
                                                <span id="fami_error"></span>
                                        </div>
                                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <label>Tags <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select tag for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                    <input type="text" name="tag_search" class="form-control" placeholder="Search Tag" id="tag_serch">
                                    <div id="suggested_tags" class="suggested_tags"></div>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3 btn-sec mt-4">
                                    <button class="btn table-filter-btn" type="button" id="seach_filter">Search</button>
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
                        <!-- @include('catalogue.combine-view') -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection
@section('script')

<script>
    
    $(document).on("change", "#all_cats", function() {
            var cat = this.value;
            $("#all_families").html('');
            $.ajax({
                url: '{{route('catalogue.fetch.family')}}',
                type: "POST",
                data: {
                    cat: cat,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: 'json',
                success: function(result) {
                    $('#all_families').html('<option value="">Select Family</option>');
                    $.each(result.families, function(key, value) {
                        $("#all_families").append('<option value="' + value.id + '">' + value.family + '</option>');
                    });
                }
            }); 
        });
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
        var tags = [];
          function updateTags(data) {
            tags = data;
            }
          $.ajax({
                url: admin_url + "get-tags",
                type: "post",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(data) {
                    updateTags(data.tags);
                }
            });
          function filterTags(searchQuery) {
            // Filter tags based on searchQuery
            var filteredTags = tags.filter(function(tag) {
                return tag.name.toLowerCase().includes(searchQuery.toLowerCase());
            });

            return filteredTags;
        }
        $('#tag_serch').on('keyup', function() {
            var searchQuery = $(this).val(); // Get search query from input
            var filteredTags = filterTags(searchQuery); // Filter tags based on search query
            if (searchQuery.trim() === '') {
                $('#suggested_tags').removeClass('active').empty();
            } else {
                $('#suggested_tags').addClass('active').empty();
                filteredTags.forEach(function(tag) {
                    $('#suggested_tags').append('<li class="search_tag" data-value="'+ tag.name +'">' + tag.name + '</li>');
                });
            }
        });
        $(document).on("click", ".search_tag", function() {
            var value = $(this).data('value');
            $('#suggested_tags').removeClass('active').empty();
            $('#tag_serch').val(value);
        });
        var ids = [];
        @foreach($added_products as $product)
            ids.push('{{ $product }}');
        @endforeach
        function show_entries(show_count)
        {
            var catalogue_id = $('#catalogue_id').val();
            var text = $('#search_value').val();
            var cat = $('#all_cats').val();
            var fam = $('#all_families').val();
            var tag = $('#tag_serch').val();
            $('.check-icon-visible').each(function () {
                ids.push($(this).data('id'));
            });
            $.ajax({
                    url: '{{route('catalogue.show_count_cat')}}',
                    type: "POST",
                    data: {
                        show_count: show_count,
                        catalogue_id: catalogue_id,
                        text: text,
                        cat: cat,
                        fam: fam,
                        tag: tag,
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
                        }else{
                            $('#grid_main').hide();
                            $('#main_list').show();
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
            var dataId = checkbox.data('id');
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
            var catalogue_id = $('#catalogue_id').val();
                $.ajax({
                url: '{{ route('add.product.catalogue') }}',
                type: "POST",
                data: {
                  ids: ids,
                  catalogue_id: catalogue_id,
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
            var cat = $('#all_cats').val();
            var fam = $('#all_families').val();
            var catalogue_id = $('#catalogue_id').val();
            var show_count = $('#show_count').val();
            var tag = $('#tag_serch').val();
            if(text !== null && text !== '' || cat !== null || fam !== 'Select Family' || tag !== '' || tag !== null)
            {
                $.ajax({
                    url: '{{ route('search.product.catalogue') }}',
                    type: "POST",
                    data: {
                      text: text,
                      cat: cat,
                      fam: fam,
                      tag: tag,
                      catalogue_id: catalogue_id,
                      show_count: show_count,
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
                toastr.error('Please choose atleast one option!');
            }
        });

        $(document).on("click","#clear_filter",function() {
            var show_count = $('#show_count').val();
            $('#search_value').val('');
            $('#all_cats').val('');
            $('#all_families').val('');
            $('#tag_serch').val('');
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
        });
        $(document).on('click','.common-btn', function() {
           var start = $(this).data('start');
           var end = $(this).data('end');
           var text = $('#search_value').val();
            var cat = $('#all_cats').val();
            var fam = $('#all_families').val();
            var show_count = $('#show_count').val();
            var catalogue_id = $('#catalogue_id').val();
            $('.check-icon-visible').each(function () {
                ids.push($(this).data('id'));
            });
           $.ajax({
              type: 'POST', 
              url: '{{route('page.product.catalogue')}}', 
              data: {
                 start: start,
                 end: end,
                 text: text,
                cat: cat,
                fam: fam,
                show_count: show_count,
                catalogue_id: catalogue_id,
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
