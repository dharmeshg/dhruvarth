<div class="media_images_class">
    @php
    $images = App\Models\MediaImage::orderBy('id', 'desc')->with('creator')->get();
    @endphp
    @if (isset($images) && $images != '' && $images->isNotEmpty())
    @foreach ($images as $val)
    <div class="media_imges_parent" data-id="{{ $val->id }}">
        <img src="{{ asset('uploads/' . $val->name) }}" class="media_images_index"
            data-id="{{ $val->id }}">
        <button class="select_button_img">
            <i class="fa fa-check" aria-hidden="true"></i>
            <i class="fa fa-minus" aria-hidden="true" style="display:none;"></i>
        </button>
    </div>
    @endforeach
    @else
    <h5> No images Found </h5>
    @endif
</div>
<div class="d-flex justify-content-end show_img_button" >
    <button class="btn btn-primary get_img_id" type="button" id="get_img_id" style="display:none;">Save</button>
</div>