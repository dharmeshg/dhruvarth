
    function begin_checkout(total_price){
        @if(isset($business_data->google_analytics_id) && !empty($business_data->google_analytics_id) && $business_data->advance_analytics == 'Yes')
        gtag("event", "begin_checkout", {
            value: total_price,
            currency: "INR",
            items: [
                @if(isset($cart_list) && !empty($cart_list) && count($cart_list) > 0)
                @foreach ($cart_list as $item)
                {
                    id: "{{$item->cart_bpr_id}}",
                    name: "{{$item->product_name}}",
                    list_name: "{{$item->product_name}}",
                    list_position: '{{$loop->index + 1}}',
                    quantity: '{{$item->no_of_product}}',
                    price: '{{$item->price}}'
                }
                @endforeach
                @endif
                ]
        });
        @endif
    }
