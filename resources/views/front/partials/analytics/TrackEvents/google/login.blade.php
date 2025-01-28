<script>
    function login(){
        @if(isset($business_data->google_analytics_id) && !empty($business_data->google_analytics_id) && $business_data->advance_analytics == 'Yes')
        gtag('event', 'login', {
            method: 'Email and Mobile'
        });
        @endif
    }
</script>