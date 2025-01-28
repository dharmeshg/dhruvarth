<script>
    function purchase(shipping_amount,payment_id,sub_total){
        @if(isset($business_data->google_analytics_id) && !empty($business_data->google_analytics_id) && $business_data->advance_analytics == 'Yes')
        gtag("event", "purchase", {
            currency: "INR",
            shipping: shipping_amount,
            transaction_id: payment_id,
            value: sub_total,
            items: [
                @if(isset($cart_list) && !empty($cart_list))
                @foreach ($cart_list as $item)
                {
                    id: "{{$item->cart_bpr_id}}",
                    name: "{{$item->product_name}}",
                    list_name: "{{$item->product_name}}",
                    list_position: '{{$loop->index + 1}}',
                    quantity: '{{$item->no_of_product}}',
                    price: '{{$item->price}}'
                },
                @endforeach
                @endif
            ]
        });
        @endif
    }
</script>