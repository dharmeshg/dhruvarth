<script>
function remove_from_cart(bpr_id,product_name,index,price,qty,total_price){
    @if(isset($business_data->google_analytics_id) && !empty($business_data->google_analytics_id) && $business_data->advance_analytics == 'Yes')
    gtag('event', 'remove_from_cart', {
        currency: 'INR',
        items: [{
            id: bpr_id,
            name: product_name,
            list_name: product_name,
            list_position: index,
            price: price,
            quantity: qty
        }],
        value: total_price
    });
    @endif
}
</script>