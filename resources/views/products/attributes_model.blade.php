<div class="modal fade" id="add_variant_model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Variants</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body add-article">
            <form id="add_variant_form">
                <div class="card-block">
                <input type="hidden" name="variant_product_id" id="variant_product_id">
                    <div class="attribute_div">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="a_metal_purity" name="main_attr[]" value="metal_purity">
                            <label class="custom-control-label" for="a_metal_purity">Metal Purity</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="a_metal_color" name="main_attr[]" value="metal_color">
                            <label class="custom-control-label" for="a_metal_color" >Metal Color</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="a_metal_weight" name="main_attr[]" value="metal_wieght">
                            <label class="custom-control-label" for="a_metal_weight" >Metal Weight</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="a_slu" name="main_attr[]" value="size">
                            <label class="custom-control-label" for="a_slu">Size</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="a_gender" name="main_attr[]" value="gender">
                            <label class="custom-control-label" for="a_gender">Gender</label>
                        </div>
                    </div>
                    {{-- <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="attr_t_type[]" value="diamond" id="diamond">
                        <label class="custom-control-label" for="diamond">Diamond</label>
                    </div> --}}
                    <div class="each_attr_options diamond_attr_options d-none">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="diamond_color" name="diamond_color">
                            <label class="custom-control-label" for="diamond_color">Color</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="diamond_clarity" name="diamond_clarity">
                            <label class="custom-control-label" for="diamond_clarity">Clarity</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="diamond_carat" name="diamond_carat">
                            <label class="custom-control-label" for="diamond_carat">Carat</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="diamond_composition" name="diamond_composition">
                            <label class="custom-control-label" for="diamond_composition">Composition</label>
                        </div>
                    </div>
                    {{-- <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="attr_t_type[]" value="pearl" id="pearl">
                        <label class="custom-control-label" for="pearl">Pearl</label>
                    </div> --}}
                    <div class="each_attr_options pearl_attr_options d-none">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="pearl_color" name="pearl_color">
                            <label class="custom-control-label" for="pearl_color">Color</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="pearl_clarity" name="pearl_clarity">
                            <label class="custom-control-label" for="pearl_clarity">Clarity</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="pearl_carat" name="pearl_carat">
                            <label class="custom-control-label" for="pearl_carat">Carat</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="pearl_composition" name="pearl_composition">
                            <label class="custom-control-label" for="pearl_composition">Composition</label>
                        </div>
                    </div>
                    {{-- <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="gemstone_main" name="attr_t_type[]" value="gemstone">
                        <label class="custom-control-label" for="gemstone_main">Gemstone</label>
                    </div> --}}
                    <div class="each_attr_options gemstone_attr_options d-none">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="gemstone_color" name="gemstone_color">
                            <label class="custom-control-label" for="gemstone_color">Color</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="gemstone_clarity" name="gemstone_clarity">
                            <label class="custom-control-label" for="gemstone_clarity">Clarity</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="gemstone_carat" name="gemstone_carat">
                            <label class="custom-control-label" for="gemstone_carat">Carat</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="gemstone_composition" name="gemstone_composition">
                            <label class="custom-control-label" for="gemstone_composition">Composition</label>
                        </div>
                    </div>
                    <div class="form-sec">
                        <label for="">Select Product <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Product" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                        <select name="variant_child_product" class="form-control" id="variant_child_product">
                            @if(isset($v_products) && count($v_products) > 0)
                            @foreach($v_products as $v_product)
                            <option value="{{ $v_product->id }}">{{ $v_product->p_title }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="save_v_changes">Save changes</button>
        </div>
      </div>
    </div>
  </div>