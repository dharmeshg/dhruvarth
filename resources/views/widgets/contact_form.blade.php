<style>
    .custom-form-class{
        padding: 0 !important;
        @if(isset($config['form_bg_img']) && $config['form_bg_img'] != null)
        background-image: url('{{ $config['form_bg_img'] }}');
        @endif
        @if(isset($config['form_bg_color']) && $config['form_bg_color'] != null)
        background-color: {{ $config['form_bg_color'] }};
        @endif
        @if(isset($config['form_bg_size']) && $config['form_bg_size'] != null)
        background-size: {{ $config['form_bg_size'] }};
        @endif
        @if(isset($config['form_bg_position']) && $config['form_bg_position'] != null)
        background-position: {{ $config['form_bg_position'] }};
        @endif
        @if(isset($config['form_bg_repeate']) && $config['form_bg_repeate'] != null)
        background-repeat: {{ $config['form_bg_repeate'] }};
        @endif
    }
</style>
<div class="from-sec common-text custom-form-class {{ isset($config['form_div_class']) && $config['form_div_class'] != null ? $config['form_div_class'] : '' }}" id="{{ isset($config['form_div_id']) && $config['form_div_id'] != null ? $config['form_div_id'] : '' }}" >
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-xxl-6 col-xl-6 xol-lg-6 col-md-12 col-sm-12 col-xs-12 form-content">
                <h2>Let's Start Talking About Your Love Story</h2>
                <p>Please submit this form for a free consultation via phone, Zoom Meeting or in person.</p>

                @include('front.includes.form')

               
            </div>
        </div>
    </div>
</div>
@section('script')
@parent

@endsection