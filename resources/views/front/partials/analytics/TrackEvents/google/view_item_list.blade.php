<script>
    $(document).ready(function () {
        @if(isset($business_data->google_analytics_id) && !empty($business_data->google_analytics_id) && $business_data->advance_analytics == 'Yes')
        gtag('event', 'view_item_list', {
            "items": [
                @if(isset($product_list_view['product_list']) and !empty($product_list_view['product_list']))
                @foreach($product_list_view['product_list'] as $single_product)
                {
                    "id": "{{ $single_product->bpr_id }}",
                    "name": "{{ $single_product->bpr_pr_title }}",
                    "list_name": "{{ $single_product->bpr_pr_title }}"
                },
                @endforeach
            @endif
                ]
        });
        @endif
    });

</script>