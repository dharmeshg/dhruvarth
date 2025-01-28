
    function add_to_wishlist(bpr_id,bpr_pr_title,bpr_bzcgm_title,price){
        @if(isset($business_data->google_analytics_id) && !empty($business_data->google_analytics_id) && $business_data->advance_analytics == 'Yes')
        <?php
        if(!isset($price) || !empty($price)){
            $price = 0.00;
        }
        ?>
            gtag('event', 'add_to_wishlist', {
            currency: 'INR',
            items: [{
                "id": bpr_id,
                "name": bpr_pr_title,
                "list_name": bpr_pr_title,
                "category": bpr_bzcgm_title,
                "quantity": 1,
                "price": price
            }],
            value: '{{$price}}'
        });
        @endif
    }