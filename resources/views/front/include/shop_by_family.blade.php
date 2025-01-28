

    @php
        $families = App\Models\Family::whereHas('products', function ($query) {
            $query->whereNotNull('p_family')
                ->where('visiblity', 1)
                ->where(function ($query) {
                    $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                });
        })->get();

        $families_f = App\Models\Family::whereHas('products', function ($query) {
            $query->whereNotNull('p_family')
                ->where('visiblity', 1)
                ->where(function ($query) {
                    $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                });
        })->take(3)->get();

        $families_s = App\Models\Family::whereHas('products', function ($query) {
            $query->whereNotNull('p_family')
                ->where('visiblity', 1)
                ->where(function ($query) {
                    $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                });
        })->skip(3)->take(50)->get();

    @endphp

    <section class="common-padding common-section shop-box-icon-section desktop_screen">
        <div class="container-md">
            <div class="shop-box-icon-carousel owl-loaded">
                @if(isset($families) && count($families) > 0)
                    @foreach($families as $fam)
                    <div class="gallery-item">
                        <a href="{{ route('front.fam.products',['fam' => $fam->slug]) }}" aria-label="Rings link" class="shop-box-icon-link">
                            <img class="img-fluid" loading="lazy" src="{{ asset('front/product_family_icons/'.$fam->svg) }}" width="35" height="35"
                                alt="{{ $fam->family }}" />
                            <h4>{{ $fam->family }}</h4>
                        </a>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <section class="common-padding common-section shop-box-icon-section mobile_screen">
        <div class="container-md">
            <div id="initial-items" class="shop-box-icon-carousel">
                <!-- Initially visible items -->
                @if(isset($families_f) && count($families_f) > 0)
                    @foreach($families_f as $fam)
                        <div class="gallery-item">
                            <a href="{{ route('front.fam.products',['fam' => $fam->slug]) }}" aria-label="Rings link" class="shop-box-icon-link">
                                <img class="img-fluid" loading="lazy" src="{{ asset('front/product_family_icons/'.$fam->svg) }}" width="35" height="35"
                                    alt="{{ $fam->family }}" />
                                <h4>{{ $fam->family }}</h4>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- <button id="show-more" class="btn btn-primary">Next</button> -->
            <div id="all-items" class="shop-box-icon-carousel hidden">
                @if(isset($families_s) && count($families_s) > 0)
                    @foreach($families_s as $fam)
                        <div class="gallery-item">
                            <a href="{{ route('front.fam.products',['fam' => $fam->slug]) }}" aria-label="Rings link" class="shop-box-icon-link">
                                <img class="img-fluid" loading="lazy" src="{{ asset('front/product_family_icons/'.$fam->svg) }}" width="35" height="35"
                                    alt="{{ $fam->family }}" />
                                <h4>{{ $fam->family }}</h4>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>