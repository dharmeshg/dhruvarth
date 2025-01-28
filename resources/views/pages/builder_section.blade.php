@extends('layouts.backend.index')
@section('main_content')
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
                            <div class="page_title_heading">
                                <h5>{{ isset($page->title) ? $page->title : '' }}</h5>
                            </div>
                            <input type="hidden" value="{{ $page->id }}" id="page_id">
                        </div>
                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 cpl-sm-12 col-xs-12">
                            <div class="card Recent-Users">
                                <div class="card-header">
                                    <h5>Sections</h5>
                                </div>
                                <div class="builder-page-main-sec">
                                    <div class="section-list">
                                        @if (isset($pagesections))
                                        @foreach ($pagesections as $val)
                                        <div class ="row p-10 full_section" id="section_{{ $val->id }}"
                                            data-id="{{ $val->id }}">
                                            <a class="black my-auto drag-layout">
                                                <i class="feather icon-command"></i>
                                            </a>
                                            @php
                                            if (isset($val->layout) && $val->layout != '') {
                                                $rows = explode(',', $val->layout);
                                            }
                                            @endphp
                                            <div class="row my-2 mx-0 col-11 bg-white layout-height">
                                                @foreach ($rows as $index => $row)
                                                <div class="col-{{ $row }} p-0 section-column"
                                                style="border:1px solid"
                                                data-order="{{ $index + 1 }}"
                                                data-section-id="{{ $val->id }}">
                                                @php
                                                $widget = App\Models\SectionWidget::where('sequence', $index + 1)
                                                ->where('section_id', $val->id)
                                                ->get();
                                                @endphp
                                                @if (isset($widget) && count($widget) > 0)
                                                @foreach ($widget as $index2 => $val2)
                                                @php
                                                $title = $val2->widget;
                                                @endphp
                                                <div class="d-flex flex-row justify-content-between px-3 py-3 section-widget"
                                                data-layout-widget-id ="{{ $val2->id }}"
                                                data-order="{{ $index2 + 1 }}">
                                                <span>{{ isset($title->title) ? $title->title : '' }}</span>
                                                <div class="widget-icons">
                                                    <a class="black editWidget"
                                                    data-widget-name="{{ isset($title->title) ? $title->title : '' }}"
                                                    data-id="{{ $val2->id }}"><i
                                                    class="feather icon-settings mx-1"></i></a>
                                                    <a class="black removeWidget"
                                                    data-id="{{ $val2->id }}"><i
                                                    class="feather icon-trash-2"></i></a>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                    <a class="black my-auto edit-section set-sec-prop"
                                    data-id="{{ $val->id }}">
                                    <i class="feather icon-settings"></i>
                                </a>
                                <a class="black my-auto ml-2 remove-section del-section"
                                data-id="{{ $val->id }}">
                                <i class="feather icon-trash-2"></i>
                            </a>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    @if ($pagesections->isempty())
                    <p class="no-section-sec"> No Section Found </p>
                    @endif
                    <p class="no-section-sec" style="display:none"> No Section Found </p>
                </div>
                <div class="add-new-sec-button">
                    <div class="">
                        <button type="button" class="btn btn-primary" id="select_layout">Add New
                        Section</button>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 cpl-sm-12 col-xs-12">
            <div class="card Recent-Users" id="section-property-sec" style="display:none;">
                <div class="card-header">
                    <div
                    class="d-flex justify-content-between align-items-center w-100 section-property-sec">
                    <h5>Section Properties</h5>
                    <a href="#properties-body" data-toggle="collapse" aria-expanded="true"
                    aria-controls="properties-body" class=""><i
                    class="feather icon-chevron-down black bold font-16 d-inline-block"></i></a>
                </div>
            </div>
            <form id="section-property-form" method="post">
                @csrf
                <input type="hidden" name="section_id" value="" id="prop-section_id">
                <input type="hidden" name="page_id" value="" id="prop-page_id">
                <div class="" id="properties-body">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="pills-home-tab" data-toggle="pill"
                            href="#pills-home" role="tab" aria-controls="pills-home"
                            aria-selected="true">Content</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill"
                            href="#pills-profile" role="tab" aria-controls="pills-profile"
                            aria-selected="false">Background</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-toggle="pill"
                            href="#pills-contact" role="tab"
                            aria-controls="pills-contact" aria-selected="false">Advance</a>
                        </li>
                    </ul>
                    <div class="tab-content section-property-tabs" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div class="form-group">
                            <label>Section Width</label>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary sm active container_class">
                                    <input type="radio" class="d-none" name="container"
                                    id="container" value="container">
                                    Container
                                </label>
                                <label class="btn btn-primary sm container_class">
                                    <input type="radio" class="d-none" name="container"
                                    id="container-fluid" value="container-fluid">
                                    Container Fluid
                                </label>
                            </div>
                        </div>
                        <div>
                            <label>Vertical Alignment</label>
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary sm active vertical_align">
                                    <input type="radio" class="d-none" name="v_alignment"
                                    id="v_top" value="top">
                                    Top
                                </label>
                                <label class="btn btn-primary sm vertical_align">
                                    <input type="radio" class="d-none" name="v_alignment"
                                    id="v_center" value="center">
                                    Center
                                </label>
                                <label class="btn btn-primary sm vertical_align">
                                    <input type="radio" class="d-none" name="v_alignment"
                                    id="v_bottom" value="bottom">
                                    Bottom
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                    aria-labelledby="pills-profile-tab">
                    <div class="form-group">
                        <label>Background Color</label>
                    </div>
                    <div class="d-flex background-color-sec">
                        <input type="text" class="form-control" placeholder="#000000"
                        id="background-color-id" name="sec_bg_color">
                        <div class="">
                            <input type="color" class="form-control"
                            id="color-picker-id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Background Image</label>
                    </div>
                    <div class="row form-sec">
                        <div
                        class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                        <div class="upload-img-sec">
                            <input type="hidden" name="sec_bg_img" id="main_sec_img"
                            value="{{ isset($article->image) ? $article->image : '' }}">
                            <div class="image_preview_div">
                                <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}"
                                alt="" id="sec_avtar" class="profile-img"
                                style="width:100px;">
                                <a id="remove_main_sec_image"
                                class="remove-sec-bg-img" style="display: none;">
                                <i class="fa fa-times" aria-hidden="true"></i></a>
                            </div>
                            <label for="" style="cursor: pointer;"
                            class="choose_file" data-val="mainsecimg">Choose
                        image</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Background Size</label>
                <select class="form-control" name="sec_bg_size" id="sec_bg_size">
                    <option>Select</option>
                    <option value="cover">cover</option>
                    <option value="auto">auto</option>
                    <option value="contain">contain</option>
                    <option value="initial">initial</option>
                    <option value="inherit">inherit</option>
                    <option value="unset">unset</option>
                </select>
            </div>
            <div class="form-group">
                <label>Background Position</label>
                <select class="form-control" name="sec_bg_position" id="sec_bg_position">
                    <option>Select</option>
                    <option value="bottom">bottom</option>
                    <option value="center">center</option>
                    <option value="inherit">inherit</option>
                    <option value="initial">initial</option>
                    <option value="left">left</option>
                    <option value="right">right</option>
                    <option value="top">top</option>
                    <option value="top">unset</option>
                </select>
            </div>
            <div class="form-group">
                <label>Background Repeat</label>
                <select class="form-control" name="sec_bg_repeate" id="sec_bg_repeate">
                    <option>Select</option>
                    <option value="no-repeat">no-repeat</option>
                    <option value="repeat">repeat</option>
                </select>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
        aria-labelledby="pills-contact-tab">
        <div class="form-group">
            <label>Add Class name</label>
            <input type="text" class="form-control" name="sec_class" id="sec_class">
        </div>
        <div class="form-group">
            <label>Add ID name</label>
            <input type="text" class="form-control" name="sec_id" id="sec_id">
        </div>
    </div>
</div>
<div id="blade-data" data-asset="{{ asset('uploads') }}"></div>
<div class="text-right p-15">
    <button type="button" class="btn btn-primary"
    id="save_sec_prop">Save</button>
</div>
</div>
</form>
</div>
<div class="card Recent-Users" id="widget-property-sec" style="display:none;">
    <div class="card-header">
        <div
        class="d-flex justify-content-between align-items-center w-100 section-property-sec">
        <h5 id="widget-title-dynamic"></h5>
        <a href="#widget-prop-body" data-toggle="collapse" aria-expanded="true"
        aria-controls="widget-prop-body" class="">
        <i class="feather icon-chevron-right black bold font-16 d-inline-block left_div_show"></i></a>
    </div>
</div>
<form id="widget-property-form" method="post">
    @csrf
    <input type="hidden" name="section_id" value="" id="prop-section_id">
    <input type="hidden" name="page_id" value="" id="prop-page_id">
    <input type="hidden" name="main_widget_id" value="" id="widget_id">
    <input type="hidden" name="main_widget_name" value=""
    id="main_widget_name">
    <div class="widget-prop-body collapse show" id="widget-prop-body">
        <ul class="nav nav-pills" id="widget-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active show" id="widget-content-tab"
                data-toggle="pill" href="#widget-content" role="tab"
                aria-controls="widget-content" aria-selected="true">Content</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="widget-style-tab" data-toggle="pill"
                href="#widget-style" role="tab" aria-controls="widget-style"
                aria-selected="false">Style</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="widget-background-tab" data-toggle="pill"
                href="#widget-background" role="tab"
                aria-controls="widget-background"
                aria-selected="false">Background</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="widget-advance-tab" data-toggle="pill"
                href="#widget-advance" role="tab"
                aria-controls="widget-advance" aria-selected="false">Advance</a>
            </li>
        </ul>
        <div class="tab-content section-property-tabs" id="widget-tabContent">

        </div>

        <div class="text-right p-15">
            <button type="button" class="btn btn-primary"
            id="save_widget_prop">Save</button>
        </div>
    </div>
</form>
<div id="button_html" style="display: none">
    @include('pages.widgets_html.button')
</div>
<div id="heading_html" style="display: none">
    @include('pages.widgets_html.heading_tag')
</div>
<div id="image_html" style="display: none">
    @include('pages.widgets_html.image')
</div>
<div id="text_editor_html" style="display: none">
    @include('pages.widgets_html.text_editor')
</div>
<div id="posts_html" style="display: none">
    @include('pages.widgets_html.posts')
</div>
<div id="services_html" style="display: none">
    @include('pages.widgets_html.services')
</div>
<div id="testimonials_html" style="display: none">
    @include('pages.widgets_html.testimonials')
</div>
<div id="our_gallery_html" style="display: none">
    @include('pages.widgets_html.our_gallery')
</div>
<div id="contact_form_html" style="display: none">
    @include('pages.widgets_html.contact_form')
</div>
</div>
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
        <div class="widget-list">
            @if (isset($widgets))
            @foreach ($widgets as $widget)
            <div class="widget-single flex-row justify-content-between px-3 py-3"
            data-widget-id= "{{ $widget->id }}"
            data-widget-name="{{ $widget->title }}">
            <span>{{ $widget->title }}</span>
        </div>
        @endforeach
        @endif
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
@include('pages.modal')
@endsection

@section('script')
<script src="{{ asset('assets/js/pagebuilder.js') }}"></script>

<script>
    const assetPathnew = "{{ asset('assets/images/user/img-demo_1041.jpg') }}";
    $(document).on('click', '#remove_sec_image', function(event) {
        event.stopPropagation();
        $('#sec_img_id').val(null);
        $('#sec_img_avtar').attr('src', assetPathnew);
        $('#remove_sec_image').css('display', 'none');
        $('#sec_img_avtar').css('opacity', '1.0');
    });
    $(document).on('click', '#remove_main_sec_image', function(event) {
        event.stopPropagation();
        $('#main_sec_img').val(null);
        $('#sec_avtar').attr('src', assetPathnew);
        $('#remove_main_sec_image').css('display', 'none');
        $('#sec_avtar').css('opacity', '1.0');
    });
    $(document).on('click', '#remove_image', function(event) {
        event.stopPropagation(); 
        $('#img_id').val(null);
        $('#profile_avtar').attr('src', assetPath);
        $('#remove_image').css('display', 'none');
        $('#profile_avtar').css('opacity', '1.0');
    });
</script>
@endsection
