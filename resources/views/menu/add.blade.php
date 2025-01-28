@extends('layouts.backend.index')
@section('main_content')

<style>
/**
*  Nestable css
*/
.dd {
  position: relative;
  display: block;
  margin: 0;
  padding: 0;
  max-width: 600px;
  list-style: none;
  font-size: 13px;
  line-height: 20px;
}

.dd-list {
  display: block;
  position: relative;
  margin: 0;
  padding: 0;
  list-style: none;
}

.dd-list .dd-list {
  padding-left: 30px;
}

.dd-collapsed .dd-list {
  display: none;
}

.dd-item,
.dd-empty,
.dd-placeholder {
  display: block;
  position: relative;
  margin: 0;
  padding: 0;
  min-height: 20px;
  font-size: 13px;
  line-height: 20px;
}

.dd-handle {
  display: block;
  /*height: 30px;*/
  margin: 5px 0;
  padding: 12px 20px !important;
  color: #495057;
  text-decoration: none;
  /*font-weight: bold;*/
  border: 1px solid #ced4da;
  background: #f4f7fa;;
  background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
  background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
  background: linear-gradient(top, #fafafa 0%, #eee 100%);
  -webkit-border-radius: 3px;
  border-radius: .25rem;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
    cursor: move;
    margin: 0 0 10px;
    background: #f4f7fa;
/*    color: #6f6f6f;*/
    padding: 5px 12px
}

.dd-handle i{
  margin-right: 10px;
}

.dd-handle:hover {
  color: #2ea8e5;
  background: #fff;
}

.dd-item > button {
      position: relative;
    cursor: pointer;
    float: left;
    width: 25px;
    height: 30px;
    margin: 0px 0px;
    padding: 0;
    text-indent: 100%;
    white-space: nowrap;
    overflow: hidden;
    border: 0;
    background: #4CAF50;
    font-size: 12px;
    line-height: 1;
    color: #fff;
    text-align: center;
    font-weight: bold;

}

.dd-item > button:before {
  content: '+';
  display: block;
  position: absolute;
  width: 100%;
  text-align: center;
  text-indent: 0;
}

.dd-item > button[data-action="collapse"]:before {
  content: '-';
}

.dd-placeholder,
.dd-empty {
  margin: 5px 0;
  padding: 0;
  min-height: 30px;
  background: #f2fbff;
  border: 1px dashed #b6bcbf;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.dd-empty {
  border: 1px dashed #bbb;
  min-height: 100px;
  background-color: #e5e5e5;
  background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
    -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-image: -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-image: linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
    linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-size: 60px 60px;
  background-position: 0 0, 30px 30px;
}

.dd-dragel {
  position: absolute;
  pointer-events: none;
  z-index: 9999;
}

.dd-dragel > .dd-item .dd-handle {
  margin-top: 0;
}

.dd-dragel .dd-handle {
  -webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
  box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
}

/**
* Nestable Extras
*/
.nestable-lists {
  display: block;
  clear: both;
  padding: 30px 0;
  width: 100%;
  border: 0;
  border-top: 2px solid #ddd;
  border-bottom: 2px solid #ddd;
}

#nestable-menu {
  padding: 0;
  margin: 20px 0;
}

#nestable-output,
#nestable2-output {
  width: 100%;
  height: 7em;
  font-size: 0.75em;
  line-height: 1.333333em;
  font-family: Consolas, monospace;
  padding: 5px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

#nestable2 .dd-handle {
  color: #fff;
  border: 1px solid #999;
  background: #bbb;
  background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
  background: -moz-linear-gradient(top, #bbb 0%, #999 100%);
  background: linear-gradient(top, #bbb 0%, #999 100%);
}

#nestable2 .dd-handle:hover {
  background: #bbb;
}

#nestable2 .dd-item > button:before {
  color: #fff;
}

.dd {
  //  float: left;
  //  width: 48 %;
  width: 100%;
}

.dd + .dd {
  margin-left: 2%;
}

.dd-hover > .dd-handle {
  background: #2ea8e5 !important;
}

/**
* Nestable Draggable Handles
*/
.dd3-content {
  display: block;
  height: 30px;
  margin: 5px 0;
  padding: 5px 10px 5px 40px;
  color: #333;
  text-decoration: none;
  font-weight: bold;
  border: 1px solid #ccc;
  background: #fafafa;
  background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
  background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
  background: linear-gradient(top, #fafafa 0%, #eee 100%);
  -webkit-border-radius: 3px;
  border-radius: 3px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.dd3-content:hover {
  color: #2ea8e5;
  background: #fff;
}

.dd-dragel > .dd3-item > .dd3-content {
  margin: 0;
}

.dd3-item > button {
  margin-left: 30px;
}

.dd3-handle {
  position: absolute;
  margin: 0;
  left: 0;
  top: 0;
  cursor: pointer;
  width: 30px;
  text-indent: 100%;
  white-space: nowrap;
  overflow: hidden;
  border: 1px solid #aaa;
  background: #ddd;
  background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
  background: -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
  background: linear-gradient(top, #ddd 0%, #bbb 100%);
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
}

.dd3-handle:before {
  content: '≡';
  display: block;
  position: absolute;
  left: 0;
  top: 3px;
  width: 100%;
  text-align: center;
  text-indent: 0;
  color: #fff;
  font-size: 20px;
  font-weight: normal;
}

.dd3-handle:hover {
  background: #ddd;
}


/*
* Nestable++
*/
.button-delete {
  position: absolute;
  top: 8px;
  right: 7px;
  padding: 5px 9px !important;
  cursor: pointer;
}

.button-edit {
  position: absolute;
  top: 8px;
  right: 30px;
  padding: 5px 9px !important;
  cursor: pointer;
}
.button-edit i{
    margin-right: 0 !important;
}
.button-delete i{
    margin-right: 0 !important;
}

#menu-editor {
  margin-top: 40px;
}

#saveButton {
  padding-right: 30px;
  padding-left: 30px;
}

.output-container {
  margin-top: 20px;
}

#json-output {
  margin-top: 20px;
}
.edit_main_menu{
  align-items:  center;
}


</style>
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">

                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row ">
                           <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="card Recent-Users mb-4">
                                    <div class="card-header">
                                        <h5>Main Menu</h5>
                                    </div>
                                  <div class="card-body card-block px-0 py-3">
                                        <form id="" action="{{ route('menu.add') }}" method="POST" class="" data-parsley-validate="" novalidate="">
                                          @csrf
                                          <input type="hidden" name="edit_main_menu" value="{{isset($menus->id) ? $menus->id : ''}}">
                                          <div class="row edit_main_menu"> 
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 mb-3">
                                                <label class="form-label" for="exampleFormControlInput1">Main Menu</label>
                                                <input class="form-control" id="menu_name" name="menu_name" type="text" required placeholder="Main Menu" value="{{isset($menus->display_location) ? $menus->display_location : ''}}" data-parsley-required-message="Please Enter Main Menu">
                                            </div>
                                      <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-12 col-sm-12 col-xs-12 mb-3">

                                          <div class="row edit_main_menu">
                                            <label class="form-label" for="exampleFormControlInput1">Set Menu Location</label>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" <?php echo isset($menus->header_menu) && $menus->header_menu ? 'checked' : ''; ?> name="header" id="header">
                                                <label class="custom-control-label" for="header">Header Menu</label>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" <?php echo isset($menus->footre_quick_links) && $menus->footre_quick_links ? 'checked' : ''; ?> name="quick_links" id="quick_links">
                                                <label class="custom-control-label" for="quick_links">Footer Quick Links</label>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 custom-control custom-checkbox">
                                                 <input type="checkbox" class="custom-control-input" <?php echo isset($menus->footre_services) && $menus->footre_services ? 'checked' : ''; ?> name="services" id="services">
                                                 <label class="custom-control-label" for="services">Footer services</label>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                                 <button type="submit" class="btn btn-lg btn-primary">Save</button>
                                            </div>
                                          </div>
                                        </div>  
                                    </div>
                                         <!--  <div class="row">  
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                                                 <button type="submit" class="btn btn-lg btn-primary">Save</button>
                                            </div>
                                          </div> -->  

                                        </form>         
                                 
                                 </div>
                            </div>
                        </div>


                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <div class="card mb-4">
                                  <!--   <div class="card-header">
                                        <h5>Edit Menu</h5>
                                    </div> -->
                                    <div class="card-body">
                                        <div class="accordion" id="accordionExample">
                                          <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                Custom Links
                                              </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                              <div class="accordion-body">
                                                <input type="hidden" id="menu_list_id" name="" value="{{isset($menus->id) ? $menus->id : ''}}">
                                                <form id="add_custom" class="" data-parsley-validate="" novalidate="">
                                                  
                                                        <!-- <input type="hidden" name="_token" value="" autocomplete="off"> -->
                                                          <div class="mb-3">
                                                              <label class="form-label" for="exampleFormControlInput1">Url</label>
                                                              <input class="form-control" id="custom_url" name="custom_url" type="text" placeholder="URl" data-parsley-required-message="Please Enter URL">
                                                          </div>
                                                          <div class="mb-3">
                                                              <label class="form-label" for="exampleFormControlInput1">Link Text</label>
                                                              <input class="form-control" id="custom_link" name="custom_link" type="text" placeholder="Link Text" data-parsley-required-message="Please Enter Link Text">
                                                          </div>
                                                                                
                                                          <div class="mb-3">
                                                              <button type="" id="add_custom_Button" class="btn btn-lg btn-primary">Add To Menu</button>
                                                          </div>
                                                </form>
                                          
                                              </div>
                                            </div>
                                          </div>
                                          <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Categories
                                              </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                              <div class="accordion-body">
                                                <form id="add_category" data-parsley-validate="" novalidate="">
                                                    @if(isset($category) && $category != "")
                                                        @foreach($category as $key => $categorys)
                                                          @php
                                                    @endphp
                                                            <div class="mb-3 custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" data-id="{{ $categorys->slug }}" name="category[]" id="category{{ $key }}" value="{{ $categorys->category }}">
                                                                <label class="custom-control-label" for="category{{ $key }}">{{ $categorys->category }}</label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                                                
                                                          <div class="mb-3">
                                                              <button type="submit" class="btn btn-lg btn-primary">Add To Menu</button>
                                                          </div>
                                                  </form>
                                            
                                              </div>
                                            </div>
                                          </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingThree">
                                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    Posts
                                                  </button>
                                                </h2>
                                                 <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                         <form id="add_posts" data-parsley-validate="" novalidate="">
                                                                   @if(isset($posts) && $posts != "")
                                                                        @foreach($posts as $key => $postss)
                                                                   
                                                                            <div class="mb-3 custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input" name="posts{{ $key }}" data-id="{{ $postss->slug }}" id="posts{{ $key }}" value="{{ $postss->title }}">
                                                                                <label class="custom-control-label" for="posts{{ $key }}">{{ $postss->title }}</label>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                                        
                                                                  <div class="mb-3">
                                                                      <button type="submit" class="btn btn-lg btn-primary">Add To Menu</button>
                                                                  </div>
                                                          </form>
                                  
                                                     </div>
                                                </div>
                                            </div>

                                             <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingFour">
                                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                    Pages
                                                  </button>
                                                </h2>
                                                 <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">

                                                         <form id="add_pages" data-parsley-validate="" novalidate="">
                                                                @if(isset($pages) && $pages != "")
                                                                        @foreach($pages as $key => $pagess)
                                                                   
                                                                            <div class="mb-3 custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input" name="pages{{ $key }}" id="pages{{ $key }}" data-id="{{ $pagess->slug }}" value="{{ $pagess->title }}">
                                                                                <label class="custom-control-label" for="pages{{ $key }}">{{ $pagess->title }}</label>
                                                                            </div>
                                                                        @endforeach
                                                                 @endif
                                                                                        
                                                                  <div class="mb-3">
                                                                      <button type="submit" class="btn btn-lg btn-primary">Add To Menu</button>
                                                                  </div>
                                                          </form>
                                  
                                                     </div>
                                                </div>
                                            </div>

                                             <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingFive">
                                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                    Service
                                                  </button>
                                                </h2>
                                                 <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">

                                                         <form id="add_service" data-parsley-validate="" novalidate="">
                                                                @if(isset($service) && $service != "")
                                                                        @foreach($service as $key => $services)
                                                                   
                                                                            <div class="mb-3 custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input" name="services{{ $key }}" id="services{{ $key }}" data-id="{{ $services->slug }}" value="{{ $services->sub_title }}">
                                                                                <label class="custom-control-label" for="services{{ $key }}">{{ $services->sub_title }}</label>
                                                                            </div>
                                                                        @endforeach
                                                                 @endif
                                                                                        
                                                                  <div class="mb-3">
                                                                      <button type="submit" class="btn btn-lg btn-primary">Add To Menu</button>
                                                                  </div>
                                                          </form>
                                  
                                                     </div>
                                                </div>
                                            </div>


                                             <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingSix">
                                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                    How to get Married
                                                  </button>
                                                </h2>
                                                 <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">

                                                         <form id="add_married" data-parsley-validate="" novalidate="">
                                                                @if(isset($married) && $married != "")
                                                                        @foreach($married as $key => $marrieds)
                                                                   
                                                                            <div class="mb-3 custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input" name="marrieds{{ $key }}" id="marrieds{{ $key }}" data-id="{{ $marrieds->slug }}" value="{{ $marrieds->title }}">
                                                                                <label class="custom-control-label" for="marrieds{{ $key }}">{{ $marrieds->title }}</label>
                                                                            </div>
                                                                        @endforeach
                                                                 @endif
                                                                                        
                                                                  <div class="mb-3">
                                                                      <button type="submit" class="btn btn-lg btn-primary">Add To Menu</button>
                                                                  </div>
                                                          </form>
                                  
                                                     </div>
                                                </div>
                                            </div>


                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
                                <div class="card Recent-Users mb-4">
                                <!--     <div class="card-header">
                                        <h5>Menu List</h5>
                                    </div> -->
                                  <div class="card-body card-block px-0 py-3">
                                      <div class="accordion" id="accordionExample2">

                                        <div class="dd nestable" id="nestable">
                                             <ol class="dd-list">
                                              @if(isset($menu_lists) && count($menu_lists))
                                              @foreach($menu_lists as $item)
                                                  @include('menu.get_menu', ['item' => $item])
                                              @endforeach
                                              @endif
                                             </ol>
                                        </div>
                                        <div class="builder-page-main-sec" id="no_menu_found" style="display: none;">
                                          <p class="no-section-sec"> No Menu Found </p>
                                        </div>
                                        <div class="mb-3" >
                                            <button style="display: none;" type="" id="nes_add" class="btn btn-lg btn-primary">Save</button>
                                        </div>

                                      </div>
                                 </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('menu.edit_menu')
@endsection
@section('script')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="./jquery.nestable.js"></script>
    <script src="./jquery.nestable++.js"></script>
    <script>
      // $('#nestable').nestable({ maxDepth: 5 }).on('change', updateOutput);
    </script>
<script src="{{ asset('assets/js/menusetting.js') }}"></script>

<script>
$(document).ready(function() {

  var nestedData = $('#nestable').nestable('serialize');
  if (nestedData != "") {
    $("#nes_add").css('display', 'block');
  }else{
    $("#no_menu_found").css('display', 'block');
  }


    // custom links

     $("#add_custom").submit(function (e) {
        e.preventDefault();
        var url = $("#custom_url").val();
      var menuname = $("#custom_link").val();
        addToMenu(menuname,url);
        $("#nes_add").css('display', 'block');
        $("#no_menu_found").css('display', 'none');
        $("#custom_url").val("");
        $("#custom_link").val("");
      });

     // categories


         $("#add_category").submit(function (e) {
            e.preventDefault();
                $("#add_category input[type='checkbox']:checked").each(function() {

                var url = admin_url +'categories/' + $(this).attr("data-id");

                var menuname = $(this).val();
                addToMenu(menuname,url);
                $("#nes_add").css('display', 'block');
                $("#no_menu_found").css('display', 'none');
                 $("#add_category")[0].reset();
                });
          
          });

      // posts

        $("#add_posts").submit(function (e) {
                e.preventDefault();
                $("#add_posts input[type='checkbox']:checked").each(function() {

                var url = BASE_URL +'/blog/' + $(this).attr("data-id");

                var menuname = $(this).val();
                addToMenu(menuname,url);
                $("#nes_add").css('display', 'block');
                $("#no_menu_found").css('display', 'none');
                $("#add_posts")[0].reset();
                });
        });

        //pages

        $("#add_pages").submit(function (e) {
       
              e.preventDefault();
                $("#add_pages input[type='checkbox']:checked").each(function() {

                var url = BASE_URL +'/' + $(this).attr("data-id");

                var menuname = $(this).val();
                addToMenu(menuname,url);
                $("#nes_add").css('display', 'block');
                $("#no_menu_found").css('display', 'none');
                $("#add_pages")[0].reset();
                });
        });

        //Service

         $("#add_service").submit(function (e) {
            e.preventDefault();
                $("#add_service input[type='checkbox']:checked").each(function() {

                var url = BASE_URL +'/service/' + $(this).attr("data-id");

                var menuname = $(this).val();
                addToMenu(menuname,url);
                $("#nes_add").css('display', 'block');
                $("#no_menu_found").css('display', 'none');
                 $("#add_service")[0].reset();
                });
          
          });

         //Married

          $("#add_married").submit(function (e) {
            e.preventDefault();
                $("#add_married input[type='checkbox']:checked").each(function() {

                var url = BASE_URL +'/how-to-get-married/' + $(this).attr("data-id");

                var menuname = $(this).val();
                addToMenu(menuname,url);
                $("#nes_add").css('display', 'block');
                $("#no_menu_found").css('display', 'none');
                 $("#add_married")[0].reset();
                });
          
          });

});
// var newIdCount = 1;
// function addToMenu(menuname,url) {

//       // var custom_url = url;
//       // var custom_link = menuname;
//       var newId = 'new-' + newIdCount;
//       var nestableList = $("#nestable");

//        nestableList.append('<div class="accordion-item mb-2" style="border-top: 1px solid #e3e3e3;"><h2 class="accordion-header" id="headingFour"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'+ newIdCount +'" aria-expanded="false" aria-controls="collapse'+ newIdCount +'">'+ menuname +'</button></h2><div id="collapse'+newIdCount +'" class="accordion-collapse collapse" aria-labelledby="headingFour"data-bs-parent="#accordionExample2"><div class="accordion-body"><form id="" action="" data-parsley-validate="" novalidate=""><div class="mb-3"><label class="form-label" for="exampleFormControlInput1">Menu Name</label><input class="form-control" id="custom_url" name="custom_url" type="text" placeholder="Menu Name" value="'+ menuname +'" data-parsley-required-message="Please Enter URL"></div><div class="mb-3"><label class="form-label" for="exampleFormControlInput1">URL</label><input class="form-control" id="custom_link" value="'+url+'" name="custom_link" type="text" placeholder="URL" data-parsley-required-message="Please Enter URL"></div><div class="mb-3"><a type="" class="">Save</a></div></form></div></div></div></div>');

//        newIdCount++;

// }

$(document).on('click', '#nes_add', function() {
  var token = $("meta[name='csrf-token']").attr("content");
  var nestedData = $('#nestable').nestable('serialize');
  console.log(nestedData);
  var id = $('#menu_list_id').val();

                    $.ajax({
                        url: '{{ route('menu.edit_menu') }}',
                        type: "post",
                        data: {
                            _token: token,
                            nestedData: nestedData,
                            id:id,
                         
                        },
                        success: function(data) {
                           if (data.status == 1) {
                                toastr.success(data.message);
                                window.location.href = '/admin/menu';
                            }

                        }
                    });
  
})
</script>
<script>
  $(document).on('click', '.close_edit_menu_model', function() {
      $("#edit_menu_modal").hide();
  })
</script>
   
@endsection
