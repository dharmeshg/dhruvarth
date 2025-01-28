@if(isset($business_data->mouse_flow_id) && !empty($business_data->mouse_flow_id))
    @include(Config::get('services.website_constant.THEME_NAME').'.partial.analytics.mouseflow')
@endif

