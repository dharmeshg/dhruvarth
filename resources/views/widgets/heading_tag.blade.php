@php
if(isset($config['heading_tag']) && $config['heading_tag'] != '' && $config['heading_tag'] != null)
{
	$tag = $config['heading_tag'];
}else{
	$tag = 'h4';
}
if(isset($config['heading_tag_color']) && $config['heading_tag_color'] != null)
{
	$color = $config['heading_tag_color'];
}else{
	$color = '';
}
if(isset($config['heading_bg_color']) && $config['heading_bg_color'] != null)
{
	$bg_color = $config['heading_bg_color'];
}else{
	$bg_color = '';
}
@endphp

<{{$tag}} class="{{ isset($config['heading_div_class']) ? $config['heading_div_class'] : '' }}" id="{{ isset($config['heading_div_id']) ? $config['heading_div_id'] : '' }}" style="color:{{ $color }};background-color:{{ $bg_color }};">{{ isset($config['heading_tag_text']) ? $config['heading_tag_text'] : '' }}</{{$tag}}>