<script>
    function signup(){
        @if(isset($business_data->google_analytics_id) && !empty($business_data->google_analytics_id) && $business_data->advance_analytics == 'Yes')
        gtag('event', 'sign_up', {
            method: 'Email and Mobile'
        });
        @endif
    }
</script>