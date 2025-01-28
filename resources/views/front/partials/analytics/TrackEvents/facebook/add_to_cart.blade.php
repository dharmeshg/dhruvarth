
    function facebook_add_to_cart(bpr_id,bpr_pr_title,bpr_bzcgm_title,price){
        fbq('track', 'AddToCart', {
            content_ids: bpr_id,
            content_type: 'product',
            content_name: bpr_pr_title,
            content_category: bpr_bzcgm_title,
            value: price,
            currency: 'INR',
            num_items: 1
        });
    }
