<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\SectionsLayout;
use App\Models\PageSection;
use App\Models\Widget;
use App\Models\SectionWidget;
use App\Models\ProjectGallery;
use App\Models\GalleryCategory;
use App\Models\Testimonial;
use App\Models\Article;
use App\Models\SidebarWidget;


class PageController extends Controller
{
    public function index($slug)
    {
        $page = Page::where('publish_status','=','Published')->where('slug', $slug)->first();
        if ($slug == 'adminer') {
            return redirect('/adminer');
            
        }else if(!$page || $page == null || $page == ''){
            abort(404, 'Page not found');
        }        
        if(isset($page->make_with_builder) && $page->make_with_builder != '' && $page->make_with_builder == '0' && $page->make_with_builder != '1')
        {
            if(isset($page->page_template) && $page->page_template != null && $page->page_template == '1')
            {
                $categories = GalleryCategory::get();
                $photos = ProjectGallery::where('is_publish',1)->latest()->get(); 
                return view('front.new_project_gallery',compact('photos','categories','page'));
            }else if(isset($page->page_template) && $page->page_template != null && $page->page_template == '2')
            {
                $testi_list = Testimonial::select('testimonials.*')->where('is_featured',1)->paginate(10);
                return view('front.testimonial', compact('testi_list','page'));
            }else if(isset($page->page_template) && $page->page_template != null && $page->page_template == '3'){
                $blog_widgets = SidebarWidget::where('sidebar_id',2)->orderby('sequence')->get();
                $blogs = Article::where('status',1)->latest()->paginate(10);
                return view('front.blogs',compact('blogs','blog_widgets','page'));
            }
            else{
                return view('front.custom_page',compact('page'));
            }
            
        }else{
            $sections = PageSection::where('page_id',$page->id)->orderby('sequence')->get();
            return view('front.custom_page_builder',compact('page','sections'));
        }
    }
}
