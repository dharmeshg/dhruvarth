function product_whatsapp_inquiry(bpr_id,bpr_pr_title,bpr_bzcgm_title,product_price,current_url){
    @if(isset($business_data->google_analytics_id) && !empty($business_data->google_analytics_id) && $business_data->advance_analytics == 'Yes')
    gtag('event', 'product_whatsapp_inquiry', {
        'event_label': bpr_pr_title,
        'event_category': bpr_bzcgm_title,
        'event_action': current_url
    });
    @endif
}