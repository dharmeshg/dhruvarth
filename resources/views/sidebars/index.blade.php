@extends('layouts.backend.index')
@section('main_content')
<style>
    .select2-dropdown{z-index: 99999;}
    .select2-container--default .select2-selection--multiple{
        background: #f4f7fa !important;
    padding: 5px 7px !important;
    font-size: 14px !important;
    border: 1px solid #ced4da !important;
    }
</style>
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->

            <!-- [ breadcrumb ] end -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- [ Main Content ] start -->

                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        </div>
                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 cpl-sm-12 col-xs-12">
                            <div class="card Recent-Users">
                                <div class="card-header">
                                    <h5>Sidebars</h5>
                                </div>
                                <div class="builder-page-main-sec">
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item mb-3" style="border-top: 1px solid #e3e3e3;">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                 Page Sidebar
                                             </button>
                                         </h2>
                                         <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="section-list">
                                                <div class ="row p-20 full_section" id="section_"
                                                data-id="">
                                                <div class="row my-2 mx-0 col-12 bg-white layout-height">
                                                    <div class="col-12 p-0 section-column"
                                                    style="border:1px solid"
                                                    data-order=""
                                                    data-sidebar-id="1">
                                                    <div class="sortable-widgets">
                                                        @if(isset($widgets) && count($widgets) > 0)
                                                        @foreach($widgets as $val)
                                                        <div class="d-flex flex-row justify-content-between px-3 py-3 section-widget"
                                                        data-layout-widget-id ="{{ $val->id }}"
                                                        data-order="{{ $val->sequence }}">
                                                        <span>{{ isset($val->widget_name) ? $val->widget_name : '' }}</span>
                                                        <div class="widget-icons-new">
                                                            <a class="black my-auto drag-layout" data-widget-name="{{ isset($val->widget_name) ? $val->widget_name : '' }}"
                                                                data-id="{{ $val->id }}">
                                                                <i class="feather icon-command"></i>
                                                            </a>
                                                            <a class="black editWidget"
                                                            data-widget-name="{{ isset($val->widget_name) ? $val->widget_name : '' }}"
                                                            data-id="{{ $val->id }}"><i
                                                            class="feather icon-settings mx-1"></i></a>
                                                            <a class="black removeWidget"
                                                            data-id="{{ $val->id }}"><i
                                                            class="feather icon-trash-2"></i></a>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                                @if ($widgets->isempty())
                                                <p class="no-section-sec m-10"> No Widgets Found </p>
                                                @endif
                                                <p class="no-section-sec m-10" id="no-section-sec2" style="display:none"> No Widgets Found </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- blog sidebar -->
                        <div class="accordion-item mb-3" style="border-top: 1px solid #e3e3e3;">
                                            <h2 class="accordion-header" id="headingtwo">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                                                 Blog Sidebar
                                             </button>
                                         </h2>
                                         <div id="collapsetwo" class="accordion-collapse collapse" aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                            <div class="section-list">
                                                <div class ="row p-20 full_section" id="section_"
                                                data-id="">
                                                <div class="row my-2 mx-0 col-12 bg-white layout-height">
                                                    <div class="col-12 p-0 section-column"
                                                    style="border:1px solid"
                                                    data-order=""
                                                    data-sidebar-id="2">
                                                    <div class="sortable-widgets">
                                                        @if(isset($blog_widgets) && count($blog_widgets) > 0)
                                                        @foreach($blog_widgets as $val)
                                                        <div class="d-flex flex-row justify-content-between px-3 py-3 section-widget"
                                                        data-layout-widget-id ="{{ $val->id }}"
                                                        data-order="{{ $val->sequence }}">
                                                        <span>{{ isset($val->widget_name) ? $val->widget_name : '' }}</span>
                                                        <div class="widget-icons-new">
                                                            <a class="black my-auto drag-layout" data-widget-name="{{ isset($val->widget_name) ? $val->widget_name : '' }}"
                                                                data-id="{{ $val->id }}">
                                                                <i class="feather icon-command"></i>
                                                            </a>
                                                            <a class="black editWidget"
                                                            data-widget-name="{{ isset($val->widget_name) ? $val->widget_name : '' }}"
                                                            data-id="{{ $val->id }}"><i
                                                            class="feather icon-settings mx-1"></i></a>
                                                            <a class="black removeWidget"
                                                            data-id="{{ $val->id }}"><i
                                                            class="feather icon-trash-2"></i></a>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                                @if ($blog_widgets->isempty())
                                                <p class="no-section-sec m-10"> No Widgets Found </p>
                                                @endif
                                                <p class="no-section-sec m-10" id="no-section-sec2" style="display:none"> No Widgets Found </p>
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

        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 cpl-sm-12 col-xs-12">


            <div class="card Recent-Users" id="widget-sec">

                <div class="card-header">
                    <div
                    class="d-flex justify-content-between align-items-center w-100 section-property-sec">
                    <h5>Widgets</h5>
                    <a href="#Widget_body" data-toggle="collapse" aria-expanded="true"
                    aria-controls="Widget_body" class=""><i
                    class="feather icon-chevron-right black bold font-16 d-inline-block left_div_show"></i></a>
                </div>
            </div>
            <div class="collapse show" id="Widget_body">
                <div class="card-body">
                    <div class="widget-list" style="max-height: 450px;overflow-y: unset;">
                        <div class="widget-single flex-row justify-content-between px-3 py-3"
                        data-widget-id= "1"
                        data-widget-name="Image">
                        <span>Image</span>
                    </div>
                    <div class="widget-single flex-row justify-content-between px-3 py-3"
                    data-widget-id= "2"
                    data-widget-name="Text Editor">
                    <span>Text Editor</span>
                </div>
                <div class="widget-single flex-row justify-content-between px-3 py-3"
                data-widget-id= "3"
                data-widget-name="Recent Posts">
                <span>Recent Posts</span>
            </div>
            <div class="widget-single flex-row justify-content-between px-3 py-3"
            data-widget-id= "4"
            data-widget-name="Category List">
            <span>Category List</span>
        </div>
        <div class="widget-single flex-row justify-content-between px-3 py-3"
        data-widget-id= "4"
        data-widget-name="How To Get Married List">
        <span>How To Get Married List</span>
    </div>
</div>
</div>
</div>
</div>
</div>
<!--[ Recent Users ] end-->

</div>
<!-- [ Main Content ] end -->
</div>
</div>
</div>
</div>
</div>
<div class="modal" tabindex="-1" id="edit_menu_modal">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <h5 class="modal-title">Widget Properties</h5>

          <button type="button" class="btn-close close_edit_menu_model" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>

      <div class="modal-body py-3">

          <div class="py-3">

            <div class="row px-3">
              <form id="widget_properties">
                <input type="hidden" name="widget_id" id="widget_prop_id">
                <input type="hidden" name="widget_name" id="widget_prop_name">
                <div id="append_html">


                </div>                    
                <div class="mb-3">
                  <button id="save_widget_prop" class="btn btn-lg btn-primary" type="button">Save</button>
              </div>
          </form>

      </div>

  </div>

</div>

</div>

</div>

</div>
@endsection

@section('script')
<script>
    $('.widget-single').draggable({
        revert: "invalid",
        helper: "clone",
        cursor: 'pointer',
        zIndex: 10000,
        start: function(event, ui) {
            ui.helper.addClass("widget-placeholder");
        }
    });
    $('.section-column').droppable({
        accept: ".widget-single",
        drop: function(event, ui) {
            let widget = $(ui.draggable).clone();
            const data = {
                widget_id: $(widget).data('widget-id'),
                widget_title: $(widget).data('widget-name'),
                order: $(this).data('order'),
                sidebar_id: $(this).data('sidebar-id')
            };
            saveWidget(data, widget, this);
        },
    });
    function saveWidget(data, widget, section) {
        $.ajax({
            type: "post",
            url: admin_url +"sidebar-setting-save",
            data: {
                section_layout_id: data.order,
                widget_id: data.widget_id,
                sidebar_id: data.sidebar_id,
                widget_title: data.widget_title
            },
            success: function(response) {
                toastr.success(response.message, 'Success');
                appendWidgetToLayout(widget, section, response.data.id, response.title);
            // updateWidgetOrder(data.order);
        },
        error: function(xhr, status, error) {
            let message = "Widget Adding Request Failed";
            if (xhr.responseJSON) {
                message = xhr.responseJSON.message;
            }
            toastr.error(message, 'ERROR!!');
        }
    });
    };
    function appendWidgetToLayout(widget, section, id, title) {
        $(widget).removeClass('mb-2');
        $(widget).removeClass('widget-single').addClass('section-widget');
        $(widget).addClass('d-flex');
        $(widget).removeClass('ui-draggable');
        $(widget).removeClass('ui-draggable-handle');
        $(widget).attr('data-layout-widget-id', id);
        $(widget).appendTo('.sortable-widgets');

        let actionMarkup = `
        <div class="widget-icons-new">
        <a class="black my-auto drag-layout data-widget-name="${title}" data-id="${id}"">
        <i class="feather icon-command"></i>
        </a>
        <a  class="black editWidget" data-widget-name="${title}" data-id="${id}"><i class="feather icon-settings mx-1"></i></a>
        <a  class="black removeWidget" data-id="${id}"><i class="feather icon-trash-2"></i></a>
        </div>`;
        if ($(".section-widget").length > 0) {
                $('.no-section-sec').hide();
        }
        $(widget).append(actionMarkup);
    };
    $('.sortable-widgets').sortable({
        handle: '.drag-layout',
        cursor: "move",
        axis: 'y',
        update: function(e, u) {
            let data = $(this).sortable('toArray', { attribute: 'data-layout-widget-id' });
            updateSectionOrder(data);
        }
    });
    function updateSectionOrder(data) {
        $.ajax({
            type: 'post',
            url: admin_url +"sidebar-sequence-change",
            data: {order:data},
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr, status, error) {
                let message = "Widgets Sorting Request Failed";
                if (xhr.responseJSON) {
                    message = xhr.responseJSON.message;
                }
                toastr.error(message, 'ERROR!!');
            }
        });
    };

    $(document).on('click', '.removeWidget', function() {
        var widget_id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to remove the Widget!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: admin_url +"sidebar-setting-delete",
                    data: {
                        widget_id: widget_id
                    },
                    success: function(response) {
                        toastr.error(response.message);
                        $(".section-widget[data-layout-widget-id='" + widget_id + "']").remove();
                        console.log($(".section-widget").length);
                        if ($(".section-widget").length === 0) {
                            $('#no-section-sec2').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Something Went Wrong!');
                    }
                });
            }
        });
    });

    $(document).on('click', '.editWidget', function() {
        openSidebarDropMenu($(this));
    });
    function openSidebarDropMenu(element) {
        "use strict";
        let widget_name = $(element).data('widget-name');
        let widget_id = $(element).data('id');
        $.ajax({
            type: "post",
            url: admin_url +"sidebar-get-html",
            data: {
                widget_name: widget_name,
                widget_id: widget_id,
            },
            success: function(res) {
                $('#widget_prop_name').val(widget_name);
                $('#widget_prop_id').val(res.data.id);
                $('#append_html').html(res.html);
                $('#page_select').select2({
                    placeholder: "Select Page"
                });
                $('#edit_menu_modal').modal('show');
                // $('#code_preview0').summernote({
                //     height: 300,
                //     toolbar: [
                //     ['style', ['bold', 'italic', 'underline', 'clear']],
                //     ['para', ['ul', 'ol']],
                //     ],
                // });
                
            },
            error: function(data, textStatus, jqXHR) {
                toastr.error("Sidebar Widget Opening Failed", "Error!");
            }
        });

    }
    $(document).on('click', '#save_widget_prop', function() {
        var data = $('#widget_properties').serialize();
        $.ajax({
            type: "post",
            url: admin_url +"sidebar-prop-save",
            data: data,
            success: function(res) {
                $('#widget_properties')[0].reset();
                $('#edit_menu_modal').modal('hide');
                toastr.success(res.message);
            },
            error: function(data, textStatus, jqXHR) {
                toastr.error("Sidebar Widget Opening Failed", "Error!");
            }
        });
    });
    $(document).on('click', '#remove_image', function() {
        event.stopPropagation();
        $('#img_id').val(null);
        $('#profile_avtar').attr('src', assetPath);
        $('#remove_image').css('display', 'none');
        $('#profile_avtar').css('opacity', '1.0');
    });
</script>
@endsection
