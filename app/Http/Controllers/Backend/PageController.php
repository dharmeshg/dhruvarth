<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\SectionsLayout;
use App\Models\PageSection;
use App\Models\Widget;
use App\Models\Updatelog;
use App\Models\SectionWidget;
use Illuminate\Support\Facades\Auth;
use App\Models\MediaImage;
use App\Models\Category;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;

class PageController extends Controller
{
    // Page Routes 
    
    public function index()
    {
        return view('pages.index');
    }

    public function add()
    {
        $parent = Page::get();
        return view('pages.add', compact('parent'));
    }
    public function list()
    {
        $pages = Page::with(['authorUser', 'parent'])->orderBy('id', 'desc')->get();
        
        $counter = 1;
        $pages->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            $item['parent_title'] = $item->parent ? $item->parent->title : '-';
            if($item->publish_status == 'Draft')
            {
                $item['formatted_published_at'] = '<p class="date_p_class"><span class="date_draft_class">Draft</span></p>';  
            }
            else{
                $item['formatted_published_at'] = '<p class="date_p_class"><span class="date_published_class">Published</span></p>';
            }
            $item['formatted_published_at'] .= Carbon::parse($item->published_at)->format('d-m-Y');
            $item['action'] = '<a class="label theme-bg2 text-white f-12" data-id="' . $item['id'] . '" href="' . route('pages.edit', $item['id']) . '" title="Click here for edit product"><i class="fa fa-edit"></i></a>';
            $item['action'] .= '<a data-href="' . route('page.delete', $item['id']) . '" data-title="testrete" data-original-title="Delete Tags" class="label theme-bg text-white f-12 page_delete" title="Click here for delete product"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            if($item->make_with_builder == '1')
            {
                $item['action'] .= '<a class="label theme-bg2 text-white f-12" href="' . route('pages.builder', $item['id']) . '" target="_blank">Page Builder</a>';
            }
            return $item;
        });

        return response()->json(['data' => $pages]);
    }
    public function edit($id)
    {
        $page = Page::findOrfail($id);
        $parent = Page::get();
        return view('pages.add', compact('page','parent'));
    }
    public function save(Request $request)
    {
        // $slug = SlugService::createSlug(Page::class, 'slug', $request->page_slug);
        if(isset($request->page_id) && $request->page_id != '')
        {
            $check = Page::where('slug', $request->page_slug)->first();
            if (isset($check) && $request->page_id != $check->id) {
                $slug = SlugService::createSlug(Page::class, 'slug', $request->page_slug);
            }else{
                $slug_update = $request->page_slug;
                $slug = Str::slug($slug_update, '-');
            }
            $page = Page::findOrfail($request->page_id); 
            $edata = json_encode($page);
            $edt = Updatelog::create(['tablename'=>'page','table_primary_id'=>$page->id,'edit_log'=>$edata]);
        }else{
            $slug = SlugService::createSlug(Page::class, 'slug', $request->page_slug);
            $page = new Page();
        }
            $page->title = isset($request->page_title) ? $request->page_title : null;
            $page->slug = $slug;
            $page->content = isset($request->page_content) ? $request->page_content : null;
            $page->published_at = isset($request->page_published_at) && $request->page_published_at != null ? $request->page_published_at : Carbon::now();
            $page->author = Auth::user()->id;
            $page->image = isset($request->page_img_id) ? $request->page_img_id : null;
            $page->visibility = isset($request->visibility) ? $request->visibility : null;
            $page->password = isset($request->post_pass) ? $request->post_pass : null;
            $page->publish_status = isset($request->publish_status) ? $request->publish_status : null;
            $page->make_with_builder = isset($request->make_with_builder)  && $request->make_with_builder =='on' ? 1 : 0;
            $page->page_slider = isset($request->page_slider)  && $request->page_slider =='on' ? 1 : 0;
            $page->header_banner = isset($request->header_banner)  && $request->header_banner =='on' ? 1 : 0;
            $page->header_banner_img = isset($request->header_banner_img) ? $request->header_banner_img : null;
            $page->header_banner_title = isset($request->header_banner_title) ? $request->header_banner_title : null;
            $page->header_banner_subtitle = isset($request->header_banner_subtitle) ? $request->header_banner_subtitle : null;
            $page->page_attribute = isset($request->page_parent) ? $request->page_parent : null;
            $page->meta_title = isset($request->meta_title) ? $request->meta_title : null; 
            $page->meta_keyword = isset($request->meta_keyword) ? $request->meta_keyword : null; 
            $page->meta_description = isset($request->meta_description) ? $request->meta_description : null;
            $page->page_index = isset($request->page_index) ? $request->page_index : 'on';
            $page->canonical_url = isset($request->canonical_url) ? $request->canonical_url : null;
            if(isset($request->make_with_builder)  && $request->make_with_builder =='on')
            {
                $page->page_template = null; 
            }else{
                $page->page_template = isset($request->page_template) ? $request->page_template : null;
            }
            $page->save();
            return redirect()->route('pages.index')->with('success', 'Page Saved Successfully.');
       
    }
    public function check_slug(Request $request)
    {
        $check = Page::where('title', $request->name)->first();
        if($check && $check != '' && $check != null)
        {
            $response['status'] = 1;
            $response['message'] = "available";
        }else{
            $response['status'] = 2;
            $response['message'] = "unavailable";
        }
        return response()->json($response);
    }

    public function delete($id)
    {
        $page = Page::findOrfail($id);
        $page->delete();
        return redirect()->route('pages.index')->with('error', 'Page Deleted Successfully.');
    }

    // Page Builder Functions 

    public function page_buider($id)
    {
        $page = Page::findOrfail($id);
        $pagesections = PageSection::where('page_id', $page->id)->orderby('sequence')->get();
        $layout = SectionsLayout::get();
        $widgets = Widget::orderby('id','desc')->get();
        $categories = Category::get();
        return view('pages.builder_section', compact('page','layout','pagesections','widgets','categories'));
    }

    public function page_sec_store(Request $request)
    {
        $section = new PageSection();
        $section->page_id = isset($request->page_id) ? $request->page_id : null;
        $section->order = isset($request->order) ? $request->order : null;
        $section->layout = isset($request->layout) ? $request->layout : null;
        $section->save();
        if($section)
        {
            return response()->json(['data' => $section]);
        }
    }

    public function page_sec_prop_store(Request $request)
    {
        $content = json_encode([
            'container' => isset($request->container) ? $request->container : '',
            'v_alignment' => isset($request->v_alignment) ? $request->v_alignment : '',
        ]);
        $background = json_encode([
            'bg_color' => isset($request->sec_bg_color) ? $request->sec_bg_color : '',
            'bg_img' => isset($request->sec_bg_img) ? $request->sec_bg_img : '',
            'bg_size' => isset($request->sec_bg_size) ? $request->sec_bg_size : '',
            'bg_position' => isset($request->sec_bg_position) ? $request->sec_bg_position : '',
            'bg_repeat' => isset($request->sec_bg_repeate) ? $request->sec_bg_repeate : '',
        ]);
        $advance = json_encode([
            'class' => isset($request->sec_class) ? $request->sec_class : '',
            'id' => isset($request->sec_id) ? $request->sec_id : '',
        ]);

        $section = PageSection::findOrfail($request->section_id);
        if($section)
        {
            $section->content = isset($content) ? $content : null;
            $section->background = isset($background) ? $background : null;
            $section->advance = isset($advance) ? $advance : null;
            $section->update();
            return response()->json(['data' => $section, 'message' => 'Page Section Properties Saved Successfully.']);
        }else{
            return response()->json(['message' => 'Something Went Wrong!']);
        }
    }
    public function page_sec_edit(Request $request)
    {
        $section = PageSection::findOrfail($request->section_id);
        if(isset($section) && $section != '')
        {
            $content = json_decode($section->content);
            $background = json_decode($section->background);
            $advance = json_decode($section->advance);
            $data['container'] = isset($content->container) ? $content->container : '';
            $data['v_alignment'] = isset($content->v_alignment) ? $content->v_alignment : '';
            $data['bg_color'] = isset($background->bg_color) ? $background->bg_color : '';
            $data['bg_img'] = isset($background->bg_img) ? $background->bg_img : '';
            $data['bg_size'] = isset($background->bg_size) ? $background->bg_size : '';
            $data['bg_position'] = isset($background->bg_position) ? $background->bg_position : '';
            $data['bg_repeat'] = isset($background->bg_repeat) ? $background->bg_repeat : '';
            $data['class'] = isset($advance->class) ? $advance->class : '';
            $data['id'] = isset($advance->id) ? $advance->id : '';
            if(isset($background->bg_img) && $background->bg_img != '' && $background->bg_img != null){
            $img = MediaImage::where('id', $background->bg_img)->first();
                $bg_img = $img->name;
            }else{
                $bg_img = null;
            }
            return response()->json(['data' => $data, 'bg_img' => $bg_img,'message' => 'Page Section Properties Found Successfully.']);
        }else{
            return response()->json(['message' => 'Something Went Wrong!']);
        }
    }
    public function page_sec_delete(Request $request)
    {
        $section = PageSection::findOrfail($request->section_id);
        if($section)
        {
            $widgets = SectionWidget::where('section_id', $section->id)->get();
            if(isset($widgets))
            {
                foreach($widgets as $val)
                {
                    $val->delete();
                }
            }
            $section->delete();
            return response()->json(['message' => 'Section Deleted Successfully.']);
        }else{
            return response()->json(['message' => 'Something Went Wrong!']);
        }
    }

    public function page_sec_change_order(Request $request)
    {
        $order = $request->section;
        foreach ($order as $index => $val) {
            PageSection::where('id', $val)->update(['sequence' => $index + 1]);
        }
        return response()->json(['message' => 'Section Sorted Successfully.']);
    }

    
}
