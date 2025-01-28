
@php
if(isset($config['button_link']) && $config['button_link'] != null)
{
	$link = $config['button_link'];
}else{
	$link = '';
}
if(isset($config['button_text']) && $config['button_text'] != null)
{
	$text = $config['button_text'];
}else{
	$text = '';
}
if(isset($config['button_target']) && $config['button_target'] != null && $config['button_target'] == 1)
{
	$target = '_blank';
}else{
	$target = '';
}
@endphp
<a href="{{ $link }}" target="{{ $target }}" class="common-btn {{ isset($config['button_div_id']) && $config['button_div_id'] != null ? $config['button_div_id'] : '' }}" id="{{ isset($config['button_div_class']) && $config['button_div_class'] != null ? $config['button_div_class'] : '' }}" >{{ $text }}</a>