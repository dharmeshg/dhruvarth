<div class="modal" tabindex="-1" id="edit_menu_modal">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <h5 class="modal-title">Edit Menu</h5>

          <button type="button" class="btn-close close_edit_menu_model" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body py-3">

          <div class="py-3">

            <div class="row px-3">
              <form id="menu-editor">
                      <div class="mb-3">
                          <label class="form-label" for="exampleFormControlInput1">Menu Name</label>
                          <input class="form-control" id="editInputName" name="editInputName" type="text" placeholder="Menu Name" required="" data-parsley-required-message="Please Enter Menu Name">
                      </div>
                       <div class="mb-3">
                          <label class="form-label" for="exampleFormControlInput1">Url</label>
                          <input class="form-control" id="editInputSlug" name="editInputSlug" type="text" placeholder="Menu Name" required="" data-parsley-required-message="Please Enter Menu Name">
                      </div>
                                            
                      <div class="mb-3">
                          <button id="editButton" class="btn btn-lg btn-primary">Save</button>
                      </div>
              </form>

            </div>

          </div>

        </div>

      </div>

    </div>

</div>