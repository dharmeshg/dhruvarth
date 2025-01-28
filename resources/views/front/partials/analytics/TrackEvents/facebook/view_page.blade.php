<script>
    $(document).ready(function () {
        fbq('track', 'ViewContent', {
            content_ids: "{{ $product->id }}",
            content_type: 'product',
            content_name: '{{ $product->p_title }}',
            content_category: '{{ $product->category->category }}',
            value: '{{ $product->p_grand_price_total }}',
            currency: 'INR',
            num_items: 1
        });
    });
</script>