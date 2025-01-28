function add_to_cart(bpr_id,bpr_pr_title,bpr_bzcgm_title,price){
        gtag('event', 'add_to_cart', {
            "items": [
                {
                    "id": bpr_id,
                    "name": bpr_pr_title,
                    "list_name": bpr_pr_title,
                    "category": bpr_bzcgm_title,
                    "quantity": 1,
                    "price": price
                }
            ]
        });
    }