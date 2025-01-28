        <!-- COLLECTIONS Section -->

            <section class="common-padding common-section collections-section product-box-section">
                <div class="container-md">

                    <div class="row">
                        @if($section->checked_title == 1)
                        
                        <h2>COLLECTIONS</h2>
                        <a href="{{route('front.collection')}}" class="view-all" aria-label="view-all-link">View all</a>
                        @endif
                        <div class="product-carousel owl-loaded">
                            @if(isset($collection) && count($collection) > 0)
                                @foreach($collection as $collection_value)
                                    <div class="col-12">
                                        <article>
                                            <div class="product-images">
                                                <div class="new-collections-tagline number-text">@if(isset($collection_value->catalogue_id) && $collection_value->catalogue_id != '') 
                                                @php 
                                                    $catalogueId = $collection_value->catalogue_id;
                                                    if (substr($catalogueId, 0, 1) == ',') {
                                                        $catalogueId = substr($catalogueId, 1);
                                                    }
                                                    $collection_cat_count = explode(",", $catalogueId); 
                                                @endphp 
                                                {{count($collection_cat_count)}} 
                                            @endif 
                                            CATALOGUE</div>
                                                <a href="{{route('collection.catalogues', ['id' => $collection_value->slug])}}" aria-label="{{isset($collection_value->name) ? $collection_value->name : ''}}">
                                                    @php
                                                        if($collection_value->cover_image && $collection_value->cover_image != '' && $collection_value->cover_image != null)
                                                        {
                                                            $frst_path = base_path('public/uploads/collections/300/'.$collection_value->cover_image);
                  
                                                            if(file_exists($frst_path))
                                                                $path = asset('uploads/collections/300/'.$collection_value->cover_image);
                                                            else
                                                                $path = asset('uploads/collections/'.$collection_value->cover_image);
                                                        }else{
                                                            $path = asset('assets/images/user/img-demo_1041.jpg');
                                                        }

                                                    @endphp
                                                    <img src="{{$path}}" class="img-fluid" loading="lazy" width="auto"
                                                        height="auto" alt="{{isset($collection_value->name) ? $collection_value->name : ''}}">
                                                </a>
                                            </div>
                                            <div class="product-details-section">
                                                <div class="inner-section">
                                                    <a href="{{route('collection.catalogues', ['id' => $collection_value->slug])}}" aria-label="{{isset($collection_value->name) ? $collection_value->name : ''}}">
                                                        <h3>{{isset($collection_value->name) ? $collection_value->name : ''}}</h3>
                                                    </a>

                                                    <a onclick="share_model('{{$collection_value->id}}','collection')" aria-label="Share" class="add-to-cart">
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