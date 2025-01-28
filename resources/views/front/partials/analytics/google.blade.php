@if(isset($bs->google_analytics_GA4_id) && !empty($bs->google_analytics_GA4_id))
@php
    $exvl = explode(',',$bs->google_analytics_GA4_id);
@endphp
    @if(count($exvl) > 0)

    @foreach($exvl as $gval)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$gval}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', '{{$gval}}');

    </script>
    @endforeach

    @endif
@endif
