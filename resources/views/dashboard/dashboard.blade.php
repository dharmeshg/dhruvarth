@extends('layouts.backend.index')
@section('main_content')
    <div class="pcoded-wrapper">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->

                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">

                                <!--[ Recent Users ] start-->
                                <div class="col-md-6 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('product.index')}}" class="">
                                    <div class="card card-social first_box">
                                        <div class="card-block">
                                            <div class="row">
                                                <h5 class="mb-3 dashboard_heading"><span class="heading_class">Total
                                                        Products</span></h5>
                                                <div class="col d-flex align-items-center justify-content-between">
                                                    <img src="{{ asset('images/dashbord/Total-Products.png') }}">
                                                    <h3>{{ isset($total_products) ? $total_products : 0 }}</h3>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('product.index' , ['type' => 'Gemstone'])}}" class="">
                                    <div class="card card-social second_box">
                                        <div class="card-block">
                                            <div class="row">
                                                <h5 class="mb-3 dashboard_heading"><span class="heading_class">Total
                                                        Gemstone</span></h5>
                                                <div class="col d-flex align-items-center justify-content-between">
                                                    <img src="{{ asset('images/dashbord/Total-Gemstone.png') }}">
                                                    <h3>{{ isset($total_gemstone) ? $total_gemstone : 0 }}</h3>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </a>
                                </div>
                                <div class="col-md-6 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('catalogue.index')}}" class="">
                                    <div class="card card-social third_box">
                                        <div class="card-block">
                                            <div class="row">
                                                <h5 class="mb-3 dashboard_heading"><span class="heading_class">Total
                                                        Catalogue</span></h5>
                                                <div class="col d-flex align-items-center justify-content-between">
                                                    <img src="{{ asset('images/dashbord/Total-Catalog.png') }}">
                                                    <h3>{{ isset($total_catalog) ? $total_catalog : 0 }}</h3>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </a>
                                </div>
                                <div class="col-md-6 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('collection.index')}}" class="">
                                    <div class="card card-social fourth_box">
                                        <div class="card-block">
                                            <div class="row">
                                                <h5 class="mb-3 dashboard_heading"><span class="heading_class">Total
                                                        Collection</span></h5>
                                                <div class="col d-flex align-items-center justify-content-between">
                                                    <img src="{{ asset('images/dashbord/Total-Collection.png') }}">
                                                    <h3>{{ isset($total_collection) ? $total_collection : 0 }}</h3>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </a>
                                </div>

                                {{-- <div class="col-xl-12 col-md-12">

                                    <div class="card">
                                        <div class="card-header dashboard_chart">
                                            <h5>Visitors</h5>
                                            <div class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-primary sm chart_toggle active">
                                                    <input type="radio" class="d-none" name="t_alignment" id="t_left" value="monthly">
                                                    Monthly
                                                </label>
                                                <label class="btn btn-primary sm chart_toggle">
                                                    <input type="radio" class="d-none" name="t_alignment" id="t_center" value="daily">
                                                    Daily
                                                </label>
                                            </div>
                                        </div>
                                        <div class="card-block">
                                            <canvas id="myChart" height="340"></canvas>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-xl-12 col-md-12 dashboard_users">
                                    <div class="Recent-Users">
                                        <div class="">
                                            <h5>Recent Products</h5>
                                        </div>
                                        <div class="px-0 py-3 dashboard_fix_tables">
                                            <div class="table-responsive">
                                                <table id="articlelist" class="dataTable no-footer" style="width: 100%;"
                                                    aria-describedby="articlelist_info">
                                                    <thead>
                                                        <tr>

                                                            <th class="" style="width: 363px;">PRODUCT NAME</th>

                                                            <th class="" style="width: 140px;">CATEGORY</th>

                                                            <th class="" style="width: 140px;">PRODUCT FAMILY</th>

                                                            <th class="" style="width: 140px;">PRICE</th>

                                                            <th class="" style="width: 100px;">SKU NO.</th>

                                                            <th class="" style="width: 80px;">STATUS</th>

                                                            <th class="" style="width: 100px;">ACTIONS</th>

                                                        </tr>
                                                    </thead>

                                                    <tbody class="new">
                                                        @if(isset($products) && count($products) > 0)
                                                        @foreach($products as $product)
                                                        @php
                                                        $p_image = App\Models\ProductImage::where('product_id',$product->id)->first();
                                                            if(isset($p_image) && $p_image != '' && $p_image != null)
                                                            {
                                                                if(isset($product->db_status) && $product->db_status != '' && $product->db_status != null && $product->db_status == 'manually')
                                                                {
                                                                    $frst_path = base_path('public/product_media/product_images/300/'.$p_image->name);
                  
                                                                    if(file_exists($frst_path))
                                                                        $path = asset('product_media/product_images/300/'.$p_image->name);
                                                                    else
                                                                        $path = asset('product_media/product_images/'.$p_image->name);
                                                                }else{
                                                                    $path = asset('uploads/'.$p_image->name);
                                                                }
                                                            }else{
                                                                $path = asset('assets/images/user/img-demo_1041.jpg');
                                                            }
                                                        @endphp
                                                        <tr class="odd">
                                                            <td>
                                                                <div class="p-img d-flex align-items-center">
                                                                    <img src="{{ $path }}"
                                                                        class="image-fuild me-2" alt="user-img" style="width: 50px;height: 50px;border: 1px solid #000;">
                                                                    <p class="m-0">{{ isset($product->p_title) ? $product->p_title : '' }}</p>
                                                                </div>
                                                            </td>
                                                            <td class="user-details">{{ isset($product->category->category) ? $product->category->category : '' }}</td>
                                                            <td class="category">{{  isset($product->family->family) ? $product->family->family : ''  }}</td>
                                                            <td class="user-name">₹ {{ number_format($product->total_price($product->id), 2, '.', ',') }}</td>
                                                            <td class="featured">{{ isset($product->p_sku) ? $product->p_sku : '0' }}</td>

                                                            <td class="Status">
                                                                <input type="checkbox" class="is_featured_class" data-id="{{ $product->id }}" data-type="simple" id="visiblity" name="is_featured"@if(isset($product->visiblity) && $product->visiblity == '1') checked @endif>
                                                            </td>
                                                            <td class="Actions">
                                                                <a class="create" href="{{ route('product.edit',['id' => $product->id,'slug' => 'simple']) }}"><img
                                                                        src="{{ asset('images/dashbord/create.png') }}"
                                                                        class="image-fuild" title="Click here to Edit Product" alt="user-img"></a>
                                                                <a class="tress delete" href="javascript:;" data-id="{{ $product->id }}" data-href="{{route('product.delete',['id' => $product->id,'slug' => 'simple'])}}"><img
                                                                        src="{{ asset('images/dashbord/delete.png') }}"
                                                                        class="image-fuild" title="Click here to Delete Product" alt="user-img"></a>
                                                            </td>
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
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    $(document).on('click', '#visiblity', function() {
    
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        var type = $(this).attr("data-type");
        // alert(id);
        // var isChecked = $(this).is(':checked');
        $.ajax({
            url: admin_url + "product-status",
            type: "post",
            data: {
                _token: token,
                // isChecked: isChecked,
                id: id,
                type: type,
            },
            success: function(data) {
            toastr.success(data.message);
            }
        });
    });


    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).data('href');
        var product_id = $(this).data('id');
        $.ajax({
            url: admin_url +"check-variant-exists",
            type: "POST",
            data: {
                product_id: product_id,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            dataType: 'json',
            success: function(result) {
                if(result.status == 1)
                {
                    var message = 'You are about to delete a product that contains variants; this action will also delete the variants associated with it.';
                }else{
                    var message = 'You are about to delete the Product!';
                }
                Swal.fire({
                    title: 'Are you sure?',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl;
                    }
                });
            }
        }); 
    });

    </script>
    
@endsection
