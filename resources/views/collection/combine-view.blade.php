<div class="data-table-sec" id="main_list">
    <table id="example" class="table table-striped" style="width:100%">
        <tr>
            <thead>    
              <th class="head-checkbox"><input type="checkbox" id="select_all" name="" ></th>
              <th class="head-product">Catalogue Name</th>
          </thead>
      </tr>
      <tbody>
        @if(isset($catalogues) && count($catalogues) > 0)
        @foreach($catalogues as $key => $item)
        @php
        if(isset($item->cover_image) && $item->cover_image != '' && $item->cover_image != null)
        {
            $frst_path = base_path('public/uploads/catalogue/300/'.$item->cover_image);
                  
            if(file_exists($frst_path))
                $url = asset('uploads/catalogue/300/'.$item->cover_image);
            else
                $url = asset('uploads/catalogue/'.$item->cover_image);

        }else{
            $url = asset('assets/images/user/img-demo_1041.jpg');
        }

        @endphp
        <tr>
          <td class="check-box-td"><input type="checkbox" id="" data-id="{{ $item->id }}" name="" class="add_cat_pro_list @if(isset($added_products) && in_array($item->id, $added_products))check-icon-visible @endif" @if(isset($added_products) && in_array($item->id, $added_products)) checked @endif></td>
          <td class="image-td"><img src="{{ $url }}" class="" ></td>
          <td class="prodcut-td">{{ isset($item->name) ? $item->name : '' }}</td>
      </tr>
      @endforeach
      @else
      <tr>
        <td colspan="2">No Catalogues Found</td>
    </tr>
    @endif
</tbody>
</table>
</div>
<div id="grid_main" style="display: none;">
    <div class="grid-view" id="grid_div" >
        <div class="row">
            @if(isset($catalogues) && count($catalogues) > 0)
            @foreach($catalogues as $key => $item)
            @php
            if(isset($item->cover_image) && $item->cover_image != '' && $item->cover_image != null)
            {
                $frst_path = base_path('public/uploads/catalogue/300/'.$item->cover_image);
                      
                if(file_exists($frst_path))
                    $url = asset('uploads/catalogue/300/'.$item->cover_image);
                else
                    $url = asset('uploads/catalogue/'.$item->cover_image);

            }else{
                $url = asset('assets/images/user/img-demo_1041.jpg');
            }
            @endphp
            <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-6 col-xs-6 grid-img-col add_cat_pro">
                <label for="">
                    <div class="vaerified_parent">
                        <img src="{{ $url }}" class="img-fluid varified_img @if(isset($added_products) && in_array($item->id, $added_products))selected @endif">
                        <span class="verified-span check-icon @if(isset($added_products) && in_array($item->id, $added_products))check-icon-visible @endif" data-id="{{ $item->id }}">
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </span>
                    </div>
                    <p>{{ isset($item->name) ? $item->name : '' }}</p>
                </label>
            </div>
            @endforeach
            @else
            <h4>No Catalogues Found</h4>
            @endif
        </div>
    </div>
</div>
@if(isset($total_count) && $total_count > 20)
<div class="filter-pagination" id="pagination">
    @php
    $totalPages = ceil($total_count / $itemsPerPage);
    $startItem_r = ($currentPage) * $itemsPerPage + 1;
    $endItem = min($currentPage * $itemsPerPage, $total_count);
    $currentPage = (int)$currentPage;
    @endphp
    @if ($currentPage > 1)
    <a class="common-btn" data-start="{{ max($startItem_r - $itemsPerPage, 1) }}" data-end="{{ $startItem_r - 1 }}">
        Previous
    </a>
    @endif
    @for ($i = 1; $i <= min($totalPages, 5); $i++)
    @php
    $startItem = ($i - 1) * $itemsPerPage + 1;
    $endItem = min($i * $itemsPerPage, $total_count);
    @endphp
    <a class="count common-btn @if($i === $currentPage+1) active @endif" data-start="{{ $startItem }}" data-end="{{ $endItem }}">
        {{ $i }}
    </a>
    @endfor
    @if (((int)$currentPage) < $totalPages && $totalPages > 5)
    @php
    $nextstartItem_r = ($currentPage+1) * $itemsPerPage + 1;
    $nextendItem_r = min($nextstartItem_r + $itemsPerPage - 1, $total_count);
    @endphp
    <a class="common-btn" data-start="{{ $nextstartItem_r }}" data-end="{{ $nextendItem_r }}">
        Next
    </a>
    @endif
</div>
@endif
