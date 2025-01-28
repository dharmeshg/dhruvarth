<?php $dash.='-- '; ?>
@foreach($subcategories as $subcategory)
    <option value="{{$subcategory->id}}" >{{$dash}}{{$subcategory->category}}</option>
    @if(count($subcategory->subcategory))
        @include('subcategoryList-option',['subcategories' => $subcategory->subcategory])
    @endif
@endforeach