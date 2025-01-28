<div class="modal" tabindex="-1" id="layout_modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Select Layout</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-3">
          <div class="py-3">
            <div class="row px-3">
                @foreach ($layout as $val)
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 cpl-sm-12 col-xs-12 my-2" id="{{ $val->id }}" data-type = "{{ $val->type }}">
                  <input class ="d-none" type="radio" name="section_layout" id="{{ $val->id }}" value="{{ $val->type }}">
                  <label for="{{ $val->id }}">
                    <img src="{{ asset('uploads/layouts/'.$val->image) }}" class="section_layout" data-type = "{{ $val->type }}">
                  </label>
                </div>
                @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>