<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Widget;
use App\Models\MediaImage;
use App\Models\SidebarWidget;
use App\Models\Page;
use App\Models\Updatelog;

class SidebarController extends Controller
{
    public function index()
    {
        $widgets = SidebarWidget::where('sidebar_id',1)->orderby('sequence')->get();
        $blog_widgets = SidebarWidget::where('sidebar_id',2)->orderby('sequence')->get();
        return view('sidebars.index',compact('widgets','blog_widgets'));
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $widget = new SidebarWidget();
        $widget->sidebar_id = isset($request->sidebar_id) ? $request->sidebar_id : null;
        $widget->widget_id = isset($request->widget_id) ? $request->widget_id : null;
        $widget->widget_name = isset($request->widget_title) ? $request->widget_title : null;
        $widget->sequence = isset($request->section_layout_id) ? $request->section_layout_id : null;
        $widget->save();
        if($widget)
        {
            return response()->json(['data' => $widget, 'message' => 'Widget Saved Successfully.' ,'title' => $request->widget_title]);
        }
    }

    public function sequence_change(Request $request)
    {
        $order = $request->order;
        foreach ($order as $index => $val) {
            SidebarWidget::where('id', $val)->update(['sequence' => $index + 1]);
        }
        return response()->json(['message' => 'Widgets Sorted Successfully.']);
    }
    public function delete(Request $request)
    {
        // dd($request->all());
        $widget = SidebarWidget::findOrfail($request->widget_id);
        if($widget)
        {
            $widget->delete();
            return response()->json(['message' => 'Widget Deleted Successfully.']);
        }else{
            return response()->json(['message' => 'Something Went Wrong!']);
        }
    }

    public function get_html(Request $request)
    {
        $widget =  SidebarWidget::findOrfail($request->widget_id);
        $pages = Page::latest()->get();

        if(isset($widget->properties) && $widget->properties != null && $widget->properties != '')
        {
            $values = json_decode($widget->properties);
        }
        if(isset($widget->included_pages) && $widget->included_pages != null && $widget->included_pages != '')
        {
            $selected_pages = explode(',', $widget->included_pages);
        }
        // dd($request->all());
        $html = '';
        if($request->widget_name == 'Recent Posts' || $request->widget_name == 'How To Get Married List' || $request->widget_name == 'Category List')
        {

            $html .= '<div class="mb-3">
                <label class="form-label" for="exampleFormControlInput1">Widget Title</label>
                <input class="form-control" id="post_title" name="widget_title" type="text" placeholder="Widget Title" value="' . (isset($values->title) ? $values->title : '') . '"></div>
                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput2">Count</label>
                    <input class="form-control" id="post_count" name="widget_count" type="number" placeholder="Count" value="' . (isset($values->count) ? $values->count : '') . '"></div>
                <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput3">Include in Pages</label>
                    <select name="page_select[]" multiple id="page_select" class="" placeholder: "Select Page">
                        <option value="0">All</option>';
                    if (isset($pages) && count($pages) > 0) {
                        foreach ($pages as $val) {
                            $html .= '<option value="' . $val->id . '" ' . (isset($widget) && isset($selected_pages) &&  in_array($val->id, $selected_pages) ? 'selected' : '') . '>' . $val->title . '</option>';
                        }
                    }
            $html .= '</select></div>';

        }
        if($request->widget_name == 'Image')
        {
            if(isset($values->img_id) && $values->img_id != '' && $values->img_id != null)
            {
                $img =  MediaImage::where('id', $values->img_id)->first();
                if($img && $img != '' && $img != null)
                {
                    $bg_img = asset('uploads/' . $img->name);
                }else{
                    $bg_img = asset('assets/images/user/img-demo_1041.jpg');
                }
            }else{
                $bg_img = asset('assets/images/user/img-demo_1041.jpg');
            }

            $html.= '<div class="mb-3">
            <div class="upload-img-sec text-center">
                <input type="hidden" name="widget_img_id" id="img_id" value="' . (isset($values->img_id) ? $values->img_id : '') . '">
                <div class="image_preview_div">
                    <img src="' . $bg_img . '" alt="" id="profile_avtar" class="profile-img" id="profile_avtar" style="width:150px;height:150px;">
                <a id="remove_image" style="left: 147px !important;"> <i class="fa fa-times" aria-hidden="true"></i></a>
                </div>
                <label for="" style="cursor: pointer;" class="choose_file">Choose image</label>
                 </div>
            </div>
            <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput3">Include in Pages</label>
                    <select name="page_select[]" multiple id="page_select" class="" placeholder: "Select Page">
                        <option value="0">All</option>';
                        if (isset($pages) && count($pages) > 0) {
                        foreach ($pages as $val) {
                            $html .= '<option value="' . $val->id . '" ' . (isset($widget) && isset($selected_pages) &&  in_array($val->id, $selected_pages) ? 'selected' : '') . '>' . $val->title . '</option>';
                        }
                    }
            $html .= '</select></div>';
        }
        if($request->widget_name == 'Text Editor')
        {
            $html.= '<div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1">Content</label>
                    <textarea class="form-control" id="code_preview0" name="content" style="height: 300px;">' . (isset($values->content) ? $values->content : '') . '</textarea></div>
                    <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput3">Include in Pages</label>
                    <select name="page_select[]" multiple id="page_select" class="" placeholder: "Select Page">
                        <option value="0">All</option>';
                        if (isset($pages) && count($pages) > 0) {
                        foreach ($pages as $val) {
                            $html .= '<option value="' . $val->id . '" ' . (isset($widget) && isset($selected_pages) &&  in_array($val->id, $selected_pages) ? 'selected' : '') . '>' . $val->title . '</option>';
                        }
                    }
            $html .= '</select></div>';
        }
        return response()->json(['html' => $html,'data' => $widget]);
    }

    public function prop_save(Request $request)
    {
        // dd($request->all());
        $widget =  SidebarWidget::findOrfail($request->widget_id);
        $edata = json_encode($widget);
        if($widget && ($request->widget_name == 'Recent Posts' || $request->widget_name == 'How To Get Married List' || $request->widget_name == 'Category List'))
        {
           $properties = json_encode([
                'title' => isset($request->widget_title) ? $request->widget_title : '',
                'count' => isset($request->widget_count) ? $request->widget_count : '',
            ]); 
           
        }
        if($widget && $request->widget_name == 'Image')
        {
            $properties = json_encode([
                'img_id' => isset($request->widget_img_id) ? $request->widget_img_id : '',
            ]);
        }
        if($widget && $request->widget_name == 'Text Editor')
        {
            $properties = json_encode([
                'content' => isset($request->content) ? $request->content : '',
            ]);
        }
        if(isset($request->page_select) && !empty($request->page_select))
        {
            $pages = implode(',', $request->page_select);
        }else{
            $pages = null;
        }
        $widget->included_pages  = isset($pages) ? $pages : null;
        $widget->properties = isset($properties) ? $properties : null;
        $edt = Updatelog::create(['tablename'=>'sidebar-widget','table_primary_id'=>$widget->id,'edit_log'=>$edata]);
        $widget->update();
        
        return response()->json(['message' => 'Widget Properties Saved Successfully.']);
    }
}
