<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\SectionsLayout;
use App\Models\PageSection;
use App\Models\Widget;
use App\Models\SectionWidget;
use Illuminate\Support\Facades\Auth;
use App\Models\MediaImage;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;
use App\Models\Updatelog;

class WidgetController extends Controller
{
    public function sec_widget_store(Request $request)
    {
        $widgets = new SectionWidget();
        $widgets->widget_id = isset($request->widget_id) ? $request->widget_id : null;
        $widgets->section_id = isset($request->section_id) ? $request->section_id : null;
        $widgets->sequence = isset($request->section_layout_id) ? $request->section_layout_id : null;
        $widgets->save();
        $title = Widget::where('id', $widgets->widget_id)->first();
        if($title)
        {
            $new_title = $title->title;
        }
        return response()->json(['data' => $widgets, 'message' => 'Widget Saved Successfully.' ,'title' => $new_title]);
        
    }

    public function sec_widget_delete(Request $request)
    {
        $id = $request->id;
        $widget = SectionWidget::findOrfail($id);
        if($widget)
        {
            $widget->delete();
            return response()->json(['message' => 'Widget Deleted Successfully.']);
        }else{
            return response()->json(['message' => 'Something Went Wrong!.']);
        }

    }

    public function sec_widget_update_order(Request $request)
    {
        $sectionId = $request->section;
        $layoutWidgetIds = $request->layout_widget_ids;
        foreach ($layoutWidgetIds as $index => $layoutWidgetId) {
            SectionWidget::where('id', $layoutWidgetId)
                ->update(['sequence' => $index + 1]);
        }
        // exit;
        return response()->json(['message' => 'Section Sorted Successfully.']);
    }

    public function sec_widget_prop_store(Request $request)
    {
        // button Widget
        $advance = json_encode([
            'class' => isset($request->widget_class) ? $request->widget_class : '',
            'id' => isset($request->widget_id) ? $request->widget_id : '',
        ]);
        if(isset($request->main_widget_name) && $request->main_widget_name != '' && $request->main_widget_name == 'Button')
        {
            $content = json_encode([
                'button_text' => isset($request->button_text) ? $request->button_text : '',
                'button_link' => isset($request->button_link) ? $request->button_link : '',
                'target_blank' => isset($request->target_blank) && $request->target_blank == 'on'? 1 : 0,
                'b_alignment' => isset($request->b_alignment) ? $request->b_alignment : '',
            ]);
            $style = json_encode([
                'normal_text_color' => isset($request->normal_text_color) ? $request->normal_text_color : '',
                'normal_bg_color' => isset($request->normal_bg_color) ? $request->normal_bg_color : '',
                'hover_text_color' => isset($request->hover_text_color) ? $request->hover_text_color : '',
                'hover_bg_color' => isset($request->hover_bg_color) ? $request->hover_bg_color : '',
                'font_size' => isset($request->font_size_c_) ? $request->font_size_c_ : '',
                'button_padding_top' => isset($request->button_padding_top_c_) ? $request->button_padding_top_c_ : '',
                'button_padding_right' => isset($request->button_padding_right_c_) ? $request->button_padding_right_c_ : '',
                'button_padding_bottom' => isset($request->button_padding_bottom_c_) ? $request->button_padding_bottom_c_ : '',
                'button_padding_left' => isset($request->button_padding_left_c_) ? $request->button_padding_left_c_ : '',
                'radius' => isset($request->radius) ? $request->radius : '',
            ]);
            $background = json_encode([
                'bg_color' => isset($request->bg_color) ? $request->bg_color : '',
            ]);
        }
        // heading tag widget
        // dd($request->all());
        if(isset($request->main_widget_name) && $request->main_widget_name != '' && $request->main_widget_name == 'Heading Tag')
        {
            $content = json_encode([
                'tag' => isset($request->heading_tag) ? $request->heading_tag : '',
                'text' => isset($request->heading_text) ? $request->heading_text : '',
                't_alignment' => isset($request->t_alignment) ? $request->t_alignment : '',
            ]);
            $style = json_encode([
                'text_color' => isset($request->text_color) ? $request->text_color : '',
            ]);
            $background = json_encode([
                'bg_color' => isset($request->bg_color) ? $request->bg_color : '',
            ]); 
        }

        // Image Widget
        if(isset($request->main_widget_name) && $request->main_widget_name != '' && $request->main_widget_name == 'Image')
        {
            $content = json_encode([
                'image' => isset($request->sec_bg_img) ? $request->sec_bg_img : '',
                'alt_name' => isset($request->img_alt_name) ? $request->img_alt_name : '',
                'link' => isset($request->img_link) ? $request->img_link : '',
                'custom_link' => isset($request->img_custom_link) ? $request->img_custom_link : '',
                'target_blank' => isset($request->target_blank) ? $request->target_blank : '',
                'i_alignment' => isset($request->i_alignment) ? $request->i_alignment : '',
            ]);
            $style = json_encode([
                'img_width' => isset($request->img_width) ? $request->img_width : '',
                'img_max_width' => isset($request->img_max_width) ? $request->img_max_width : '',
                'img_height' => isset($request->img_height) ? $request->img_height : '',
            ]);
            $background = json_encode([
                'bg_color' => isset($request->img_bg_color) ? $request->img_bg_color : '',
            ]); 
        }
        // dd($request->all());
        // Text Editor
        if(isset($request->main_widget_name) && $request->main_widget_name != '' && $request->main_widget_name == 'Text Editor')
        {
            $content = json_encode([
                'text_content' => isset($request->text_content) ? $request->text_content : '',
                't_alignment' => isset($request->t_alignment) ? $request->t_alignment : '',
            ]);
            
            $background = json_encode([
                'bg_color' => isset($request->text_bg_color) ? $request->text_bg_color : '',
                'bg_img' => isset($request->text_bg_img) ? $request->text_bg_img : '',
                'bg_size' => isset($request->text_bg_size) ? $request->text_bg_size : '',
                'bg_position' => isset($request->text_bg_position) ? $request->text_bg_position : '',
                'bg_repeate' => isset($request->text_bg_repeate) ? $request->text_bg_repeate : '',
            ]);
        }

        //Posts
        if(isset($request->main_widget_name) && $request->main_widget_name != '' && $request->main_widget_name == 'Posts')
        {
            $content = json_encode([
                'post_type' => isset($request->post_type) ? $request->post_type : '',
                'post_category' => isset($request->post_cat_div) ? $request->post_cat_div : '',
                'post_style' => isset($request->post_style) ? $request->post_style : '',
                'column' => isset($request->P_column) ? $request->P_column : '',
                'count' => isset($request->post_count) ? $request->post_count : '',
            ]);
            $style = json_encode([
                'title_color' => isset($request->post_t_color) ? $request->post_t_color : '',
                'title_hover_color' => isset($request->post_th_color) ? $request->post_th_color : '',
                'subtitle_color' => isset($request->post_st_color) ? $request->post_st_color : '',
                'subtitle_hover_color' => isset($request->post_sth_color) ? $request->post_sth_color : '',
            ]);
            $background = json_encode([
                'post_bg_color' => isset($request->post_bg_color) ? $request->post_bg_color : '',
                'post_bg_img' => isset($request->post_bg_img) ? $request->post_bg_img : '',
                'post_bg_size' => isset($request->post_bg_size) ? $request->post_bg_size : '',
                'post_bg_position' => isset($request->post_bg_position) ? $request->post_bg_position : '',
                'post_bg_repeate' => isset($request->post_bg_repeate) ? $request->post_bg_repeate : '',
            ]); 
        } 
        //Services 
        if(isset($request->main_widget_name) && $request->main_widget_name != '' && $request->main_widget_name == 'Service Section')
        {
            $content = json_encode([
                'service_style' => isset($request->service_style) ? $request->service_style : '',
                'service_count' => isset($request->service_count) ? $request->service_count : '',
            ]);
            $style = json_encode([
                'service_title_color' => isset($request->service_t_color) ? $request->service_t_color : '',
                'service_title_hover_color' => isset($request->service_th_color) ? $request->service_th_color : '',
                'service_subtitle_color' => isset($request->service_st_color) ? $request->service_st_color : '',
                'service_subtitle_hover_color' => isset($request->service_sth_color) ? $request->service_sth_color : '',
            ]);
            $background = json_encode([
                'service_bg_color' => isset($request->service_bg_color) ? $request->service_bg_color : '',
                'service_bg_img' => isset($request->service_bg_img) ? $request->service_bg_img : '',
                'service_bg_size' => isset($request->service_bg_size) ? $request->service_bg_size : '',
                'service_bg_position' => isset($request->service_bg_position) ? $request->service_bg_position : '',
                'service_bg_repeate' => isset($request->service_bg_repeate) ? $request->service_bg_repeate : '',
            ]); 
        }
        //Testimonials 
        if(isset($request->main_widget_name) && $request->main_widget_name != '' && $request->main_widget_name == 'Testimonial Section')
        {
            $content = json_encode([
                'testimonial_style' => isset($request->testimonial_style) ? $request->testimonial_style : '',
                'testimonial_count' => isset($request->testimonial_count) ? $request->testimonial_count : '',
            ]);
            $style = json_encode([
                'testimonial_title_color' => isset($request->testimonial_t_color) ? $request->testimonial_t_color : '',
                'testimonial_title_hover_color' => isset($request->testimonial_th_color) ? $request->testimonial_th_color : '',
                'testimonial_subtitle_color' => isset($request->testimonial_st_color) ? $request->testimonial_st_color : '',
                'testimonial_subtitle_hover_color' => isset($request->testimonial_sth_color) ? $request->testimonial_sth_color : '',
            ]);
            $background = json_encode([
                'testimonial_bg_color' => isset($request->testimonial_bg_color) ? $request->testimonial_bg_color : '',
                'testimonial_bg_img' => isset($request->testimonial_bg_img) ? $request->testimonial_bg_img : '',
                'testimonial_bg_size' => isset($request->testimonial_bg_size) ? $request->testimonial_bg_size : '',
                'testimonial_bg_position' => isset($request->testimonial_bg_position) ? $request->testimonial_bg_position : '',
                'testimonial_bg_repeate' => isset($request->testimonial_bg_repeate) ? $request->testimonial_bg_repeate : '',
            ]); 
        }
        //Gallery
        if(isset($request->main_widget_name) && $request->main_widget_name != '' && $request->main_widget_name == 'Our Gallary')
        {
            $content = json_encode([
                'gallery_style' => isset($request->gallery_style) ? $request->gallery_style : '',
                'gallery_column' => isset($request->g_column) ? $request->g_column : '',
                'gallery_count' => isset($request->gallery_count) ? $request->gallery_count : '',
            ]);
            $style = json_encode([
                'gallery_title_color' => isset($request->gallery_t_color) ? $request->gallery_t_color : '',
                'gallery_title_hover_color' => isset($request->gallery_th_color) ? $request->gallery_th_color : '',
                'gallery_subtitle_color' => isset($request->gallery_st_color) ? $request->gallery_st_color : '',
                'gallery_subtitle_hover_color' => isset($request->gallery_sth_color) ? $request->gallery_sth_color : '',
            ]);
            $background = json_encode([
                'gallery_bg_color' => isset($request->gallery_bg_color) ? $request->gallery_bg_color : '',
                'gallery_bg_img' => isset($request->gallery_bg_img) ? $request->gallery_bg_img : '',
                'gallery_bg_size' => isset($request->gallery_bg_size) ? $request->gallery_bg_size : '',
                'gallery_bg_position' => isset($request->gallery_bg_position) ? $request->gallery_bg_position : '',
                'gallery_bg_repeate' => isset($request->gallery_bg_repeate) ? $request->gallery_bg_repeate : '',
            ]); 
        }
        // contact
        if(isset($request->main_widget_name) && $request->main_widget_name != '' && $request->main_widget_name == 'Contact Form')
        {
            $background = json_encode([
                'contact_bg_color' => isset($request->contact_bg_color) ? $request->contact_bg_color : '',
                'contact_bg_img' => isset($request->contact_bg_img) ? $request->contact_bg_img : '',
                'contact_bg_size' => isset($request->contact_bg_size) ? $request->contact_bg_size : '',
                'contact_bg_position' => isset($request->contact_bg_position) ? $request->contact_bg_position : '',
                'contact_bg_repeate' => isset($request->contact_bg_repeate) ? $request->contact_bg_repeate : '',
            ]); 
        }
        $widget = SectionWidget::findOrfail($request->main_widget_id);
        $edata = json_encode($widget);

        if($widget)
        {
            $widget->content = isset($content) ? $content : null;
            $widget->style = isset($style) ? $style : null;
            $widget->background = isset($background) ? $background : null;
            $widget->advanced = isset($advance) ? $advance : null;
            $edt = Updatelog::create(['tablename'=>'section-widget','table_primary_id'=>$widget->id,'edit_log'=>$edata]);
            $widget->update();
            return response()->json(['data' => $widget, 'message' => 'Widget Properties Saved Successfully.']);
        }else{
            return response()->json(['message' => 'Something Went Wrong!']);
        }
    }
    public function sec_widget_prop_get(Request $request)
    {
        $widget = SectionWidget::findOrfail($request->widget_id);
        $data['content'] = json_decode($widget->content);
        $data['style'] = json_decode($widget->style);
        $data['background'] = json_decode($widget->background);
        $data['advanced'] = json_decode($widget->advanced);

        if(isset($data['background']->bg_img) && $data['background']->bg_img != '' && $data['background']->bg_img != null){
        $img1 = MediaImage::where('id', $data['background']->bg_img)->first();
            $data['back_img'] = $img1->name;
        }else{
            $data['back_img'] = null;
        }
        if(isset($data['background']->post_bg_img) && $data['background']->post_bg_img != '' && $data['background']->post_bg_img != null){
        $img2 = MediaImage::where('id', $data['background']->post_bg_img)->first();
            $data['post_back_img'] = $img2->name;
        }else{
            $data['post_back_img'] = null;
        }
        if(isset($data['background']->service_bg_img) && $data['background']->service_bg_img != '' && $data['background']->service_bg_img != null){
        $img3 = MediaImage::where('id', $data['background']->service_bg_img)->first();
            $data['service_back_img'] = $img3->name;
        }else{
            $data['service_back_img'] = null;
        }
        if(isset($data['background']->testimonial_bg_img) && $data['background']->testimonial_bg_img != '' && $data['background']->testimonial_bg_img != null){
        $img4 = MediaImage::where('id', $data['background']->testimonial_bg_img)->first();
            $data['testi_back_img'] = $img4->name;
        }else{
            $data['testi_back_img'] = null;
        }
        if(isset($data['background']->gallery_bg_img) && $data['background']->gallery_bg_img != '' && $data['background']->gallery_bg_img != null){
        $img5 = MediaImage::where('id', $data['background']->gallery_bg_img)->first();
            $data['gallery_back_img'] = $img5->name;
        }else{
            $data['gallery_back_img'] = null;
        }
        if(isset($data['background']->contact_bg_img) && $data['background']->contact_bg_img != '' && $data['background']->contact_bg_img != null){
        $img6 = MediaImage::where('id', $data['background']->contact_bg_img)->first();
            $data['contact_back_img'] = $img6->name;
        }else{
            $data['contact_back_img'] = null;
        }
        if(isset($data['content']->image) && $data['content']->image != '' && $data['content']->image != null){
        $img = MediaImage::where('id', $data['content']->image)->first();
            $data['cont_img'] = $img->name;
        }else{
            $data['cont_img'] = null;
        }
        if($widget && $data)
        {
            return response()->json(['data' => $data, 'message' => 'Widget Properties found Successfully.']);
        }else{
            return response()->json(['message' => 'Widget Properties not found!']);
        }
    }
}
