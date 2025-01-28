<li class="dd-item" data-id="new-{{ $item->id }}" data-name="{{ $item->name }}" data-slug="{{ $item->slug }}" data-new="{{ $item->id }}" data-deleted="0">
    <div class="dd-handle"><i class="feather icon-command"></i>{{ $item->name }}</div>
    <span class="button-delete" data-owner-id="new-{{ $item->id }}"> <i class="fa fa-times" aria-hidden="true"></i></span><span class="button-edit" data-owner-id="new-{{ $item->id }}"> <i class="fa fa-pencil" aria-hidden="true"></i></span>
    
    @if(count($item->children))
        <ol class="dd-list">
            @foreach($item->children as $child)
                @include('menu.get_menu', ['item' => $child])
            @endforeach
        </ol>
    @endif
</li>