<script>
    $(document).ready(function () {
        gtag('event', 'view_item', {
            "items": [
                {
                    "id": "{{ $product_details->bpr_id }}",
                    "name": "{{ $product_details->p_title }}",
                    "list_name": "{{ $product_details->p_title }}",
                    "category": "{{ $product_details->$product->category->category }}",
                    "quantity": 1,
                    "price": '{{ $product->p_grand_price_total }}'
                }
            ]
        });
    });
</script>