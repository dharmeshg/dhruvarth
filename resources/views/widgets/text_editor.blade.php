<style>
    .custom-editor-class{
        @if(isset($config['editor_bg_img']) && $config['editor_bg_img'] != null)
        background-image: url('{{ $config['editor_bg_img'] }}');
        @endif
        @if(isset($config['editor_bg_color']) && $config['editor_bg_color'] != null)
        background-color: {{ $config['editor_bg_color'] }};
        @endif
        @if(isset($config['editor_bg_size']) && $config['editor_bg_size'] != null)
        background-size: {{ $config['editor_bg_size'] }};
        @endif
        @if(isset($config['editor_bg_position']) && $config['editor_bg_position'] != null)
        background-position: {{ $config['editor_bg_position'] }};
        @endif
        @if(isset($config['editor_bg_repeate']) && $config['editor_bg_repeate'] != null)
        background-repeat: {{ $config['editor_bg_repeate'] }};
        @endif
        @if(isset($config['editor_t_alignment']) && $config['editor_t_alignment'] != null)
        text-align: {{ $config['editor_t_alignment'] }};
        @endif
    }
</style>
<div class="custom-editor-class {{ isset($config['editor_div_class']) && $config['editor_div_class'] != null ? $config['editor_div_class'] : '' }}" id="{{ isset($config['editor_div_id']) && $config['editor_div_id'] != null ? $config['editor_div_id'] : '' }}">
	{!! html_entity_decode($config['editor_content']) !!}
</div>