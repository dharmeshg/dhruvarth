
@php
if(isset($config['image_link']) && $config['image_link'] != null && $config['image_link'] == 'media_file')
{
	$link = $config['image_bg_img'];

}else{
	$link = $config['image_custom_link'];
}
if(isset($config['image_target']) && $config['image_target'] != null && $config['image_target'] == 'on')
{
	$target = '_blank';

}else{
	$target = '';
}
@endphp
<a @if(isset($link) && $link != '' && $link != null) href="{{ isset($link) ? $link : '#' }}" @endif target="{{ isset($target) ? $target : '' }}">
<img src="{{ $config['image_bg_img'] }}" class="img-fluid" alt="{{ isset($config['image_alt_tag']) ? $config['image_alt_tag'] : '' }}">
</a>