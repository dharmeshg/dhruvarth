
    function InitiateCheckout(total_price){
        @if(isset($bs->facebook_pixel_id) && !empty($bs->facebook_pixel_id) && $bs->advance_analytics == 'Yes')
        fbq("track", "InitiateCheckout", {
            content_type: "product",
            value: total_price,
            currency: "INR"
        });
        @endif
    }