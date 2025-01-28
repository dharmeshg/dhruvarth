
    function facebook_add_to_wishlist(bpr_id,bpr_pr_title,bpr_bzcgm_title,price){
        @if(isset($bs->facebook_pixel_id) && !empty($bs->facebook_pixel_id) && $bs->advance_analytics == 'Yes')
        fbq('track', 'AddToWishlist', {
            content_ids: bpr_id,
            content_type: 'product',
            content_name: bpr_pr_title,
            content_category: bpr_bzcgm_title,
            value: price,
            currency: 'INR',
            num_items: 1
        });
        @endif
    }
