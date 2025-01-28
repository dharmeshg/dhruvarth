<script>
    function facebook_purchase(sub_total){
        @if(isset($bs->facebook_pixel_id) && !empty($bs->facebook_pixel_id) && $bs->advance_analytics == 'Yes')
        fbq("track", "Purchase", {
            content_type: "product",
            value: sub_total,
            currency: "INR"
        });
        @endif
    }
</script>