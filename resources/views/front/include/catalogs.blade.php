 

            <section class="common-padding common-section catalogues-section product-box-section">
                <div class="container-md">

                    <div class="row">
                        @if($section->checked_title == 1)
                            <h2>CATALOGUES</h2>
                            <a href="{{route('front.catalogue')}}" class="view-all" aria-label="view-all-link">View all</a>
                        @endif
                        <div class="product-carousel owl-loaded">
                            @if(isset($catalogs) && count($catalogs) > 0)
                                @foreach($catalogs as $catalogs_value)
                                    <div class="col-12">
                                        <article>
                                            <div class="product-images">
                                                <div class="new-collections-tagline number-text">
                                                    @if(isset($catalogs_value->product_id) && $catalogs_value->product_id != '')
                                                    @php
                                                        $catalogs_pro_count = explode(",", $catalogs_value->product_id);
                                                        $filtered_count = count(array_filter($catalogs_pro_count));
                                                        $pro_counts = App\Models\Product::whereIn('id',$catalogs_pro_count)->where('visiblity',1)->count();
                                                    @endphp
                                                    {{ $pro_counts }} PRODUCTS
                                                    @endif
                                            </div>

                                                @php
                                                    if($catalogs_value->cover_image && $catalogs_value->cover_image != '' && $catalogs_value->cover_image != null)
                                                    {
                                                        $frst_path = base_path('public/uploads/catalogue/300/'.$catalogs_value->cover_image);
                          
                                                        if(file_exists($frst_path))
                                                            $path = asset('uploads/catalogue/300/'.$catalogs_value->cover_image);
                                                        else
                                                            $path = asset('uploads/catalogue/'.$catalogs_value->cover_image);
                                                    }else{
                                                        $path = asset('assets/images/user/img-demo_1041.jpg');
                                                    }
                                                @endphp
                                                <a href="{{route('catalogue.product', ['id' => $catalogs_value->slug])}}" aria-label="Product Image">
                                                    <img src="{{$path}}" class="img-fluid" loading="lazy" width="auto"
                                                        height="auto" alt="{{ isset($catalogs_value->name) ? $catalogs_value->name : '' }}">
                                                </a>
                                            </div>
                                            <div class="product-details-section">
                                                <div class="inner-section">
                                                    <a href="{{route('catalogue.product', ['id' => $catalogs_value->slug])}}" aria-label="{{ isset($catalogs_value->name) ? $catalogs_value->name : '' }}">
                                                        <h3>{{ isset($catalogs_value->name) ? Str::limit($catalogs_value->name, 50) : '' }}</h3>
                                                    </a>

                                                    <a onclick="share_model('{{$catalogs_value->id}}','catalogs')" aria-label="Share" class="add-to-cart">
                                                        <img src="{{ asset('front/src/images/share-btn-icon.svg') }}" width="18" height="18">
                                                    </a>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </section>