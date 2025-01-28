<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sections;
use App\Models\Category;
use App\Models\Article;
use App\Models\Updatelog;
use App\Models\Tags;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Comment;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ArticleController extends Controller
{
    public function index()
    {
        return view('articles.index');
    }
    public function list(Request $request)
    {

        $sections_list = Article::select(
            'articles.id',
            'articles.image',
            'articles.is_featured',
            'articles.title',
            'articles.category_id',
            'articles.author',
            'articles.status',
            DB::raw('GROUP_CONCAT(categories.category SEPARATOR ", ") AS Cat_name'),
            'users.name AS authorname','media_images.name AS Imagename'
        )
            ->join('categories', 'articles.category_id', 'LIKE', DB::raw('CONCAT("%", categories.id, "%")'))
            ->join('users', 'articles.author', '=', 'users.id')
            ->leftJoin('media_images', function ($join) {
                $join->on('articles.image', '=', 'media_images.id')
                     ->whereNotNull('articles.image');
            })
            ->groupBy('articles.id', 'articles.image', 'articles.is_featured', 'articles.title', 'articles.category_id', 'articles.author', 'media_images.name', 'users.name','articles.status')
            ->orderBy('articles.id', 'desc')
            ->get();

        $counter = 1;
        $sections_list->transform(function ($item) use (&$counter) {

            $item['ser_id'] = $counter++;
            if (isset($item['Imagename']) && $item['Imagename'] != '') {
                $item['image'] = '<img src="' . asset('uploads/' . $item['Imagename']) . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;">';
            } else {
                $item['image'] = '<img src="' . asset('assets/img/new-profile.svg') . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;">';
            }
            $item['author'] = $item['authorname'];
            $item['section'] = $item['sec_name'];
            $item['category'] = $item['Cat_name'];
            if ($item['is_featured'] == '1') {
                $item['featured'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle"  id="is_featured" name="is_featured" checked class="is_featured_class">';
            } else {
                $item['featured'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured" name="is_featured" class="is_featured_class">';
            }
            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_status"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_status"  class="is_featured_class">';
            }
            $item['action'] = '<a class="label theme-bg2 text-white f-12" data-id="' . $item['id'] . '" href="' . route('articles.edit', $item['id']) . '"><i class="fa fa-edit"></i></a>';
            $item['action'] .= '<a data-href="' . route('articles.delete', $item['id']) . '" data-title="testrete" data-original-title="Delete sections" class="label theme-bg text-white f-12 articles_delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            return $item;
        });

        return response()->json(['data' => $sections_list]);
    }
    public function add()
    {
        $sections = Sections::select('*')->where('deleted_at', null)->get();
        $tags = Tags::select('*')->where('deleted_at', null)->get();
        $categories = Category::select('*')->where('parent_category', 0)->where('deleted_at', null)->get();
        return view('articles.add', compact('sections', 'tags','categories'));
    }
    public function get_categories(Request $request)
    {
        $categories = Category::where('sections_id', $request->section_id)->get();
        return response()->json(['categories' => $categories]);
    }
    public function store(Request $request)
    {
        $slug = SlugService::createSlug(Article::class, 'slug', $request->article_Slug);
        $article = new Article();
        $article->title = isset($request->article_title) ? $request->article_title : null;
        $article->short_description = isset($request->article_short_desc) ? $request->article_short_desc : null;
        $article->content = isset($request->article_content) ? $request->article_content : null;
        $article->slug = $slug;
        if (isset($request->artical_categories) && $request->artical_categories != '') {
            $cats = implode(',', $request->artical_categories);
        } else {
            $cats = null;
        }
        $article->category_id = $cats;
        if (isset($request->artical_tags) && $request->artical_tags != '') {
            $tags = implode(',', $request->artical_tags);
        } else {
            $tags = null;
        }
        $article->tag_id = $tags;
        $article->published_at = isset($request->article_published_at) ? $request->article_published_at : null;
        if (isset($request->is_featured) && $request->is_featured == 'on') {
            $featured = '1';
        } else {
            $featured = '0';
        }
        $article->is_featured = $featured;
        $article->author = Auth::user()->id;
        $article->publish_status = isset($request->publish_status) ? $request->publish_status : null;
        $article->visibility = isset($request->visibility) ? $request->visibility : null;
        $article->password = isset($request->post_pass) ? $request->post_pass : null;
        $article->format = isset($request->format) ? $request->format : null;
        $article->image = isset($request->article_img) ? $request->article_img : null;
        $article->meta_title = isset($request->meta_title) ? $request->meta_title : null; 
        $article->meta_keyword = isset($request->meta_keyword) ? $request->meta_keyword : null; 
        $article->meta_description = isset($request->meta_description) ? $request->meta_description : null; 
        $article->page_index = isset($request->page_index) ? $request->page_index : 'on';
        $article->canonical_url = isset($request->canonical_url) ? $request->canonical_url : null;
        $article->save();
        return redirect()->route('articles.index')->with('success', 'Post Added Successfully.');

    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $sections = Sections::select('*')->where('deleted_at', null)->get();
        $tags = Tags::select('*')->where('deleted_at', null)->get();
        $categories = Category::where('sections_id', $article->section_id)->where('parent_category', 0)->get();
        return view('articles.add', compact('article', 'sections', 'tags', 'categories'));
    }
    public function update(Request $request, $id)
    {
        // $slug = SlugService::createSlug(Article::class, 'slug', $request->article_Slug);
        $check = Article::where('slug', $request->article_Slug)->first();
        
        if (isset($check) && $id != $check->id) {
            $slug = SlugService::createSlug(Article::class, 'slug', $request->article_Slug);
        }else{
            $slug_update = $request->article_Slug;
            $slug = Str::slug($slug_update, '-');
        }
        $article = Article::findOrfail($id);
        $edata = json_encode($article);
        $article->title = isset($request->article_title) ? $request->article_title : null;
        $article->short_description = isset($request->article_short_desc) ? $request->article_short_desc : null;
        $article->content = isset($request->article_content) ? $request->article_content : null;
        $article->slug = $slug;
        if (isset($request->artical_categories) && $request->artical_categories != '') {
            $cats = implode(',', $request->artical_categories);
        } else {
            $cats = null;
        }
        $article->category_id = $cats;
        if (isset($request->artical_tags) && $request->artical_tags != '') {
            $tags = implode(',', $request->artical_tags);
        } else {
            $tags = null;
        }
        $article->tag_id = $tags;
        $article->published_at = isset($request->article_published_at) ? $request->article_published_at : null;
        if (isset($request->is_featured) && $request->is_featured == 'on') {
            $featured = '1';
        } else {
            $featured = '0';
        }
        $article->is_featured = $featured;
        $article->publish_status = isset($request->publish_status) ? $request->publish_status : null;
        $article->author = Auth::user()->id;
        $article->visibility = isset($request->visibility) ? $request->visibility : null;
        $article->password = isset($request->post_pass) ? $request->post_pass : null;
        $article->format = isset($request->format) ? $request->format : null;
        $article->image = isset($request->article_img) ? $request->article_img : null;
        $article->meta_title = isset($request->meta_title) ? $request->meta_title : null; 
        $article->meta_keyword = isset($request->meta_keyword) ? $request->meta_keyword : null; 
        $article->meta_description = isset($request->meta_description) ? $request->meta_description : null; 
        $article->page_index = isset($request->page_index) ? $request->page_index : 'on';
        $article->canonical_url = isset($request->canonical_url) ? $request->canonical_url : null;
        if($article->update()){
            $edt = Updatelog::create(['tablename'=>'articles','table_primary_id'=>$article->id,'edit_log'=>$edata]);
            return redirect()->route('articles.index')->with('success', 'Post Updated Successfully.');
        }else{
            return redirect()->back()->with('error', 'Error In updating, Please try again.');
        }
        
    }

    public function delete($id)
    {
        if ($id != "") {
            $record = Article::find($id);
            if (isset($record->image) && $record->image != "") {
                $remove_path = public_path('uploads/article/' . $record->image);
                if (File::exists(public_path('uploads/article/' . $record->image))) {
                    File::delete($remove_path);
                }
            }

            $record->delete();
            return redirect()->route('articles.index')
                ->withSuccess('Post Delete Successfully.');

        }
    }

    public function check_featured(Request $request)
    {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Featured canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['is_featured'] = 0;
            $save = Article::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Featured Update Successfully";

        } else {
            $data['is_featured'] = 1;
            $save = Article::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Featured Update Successfully";

        }
        return response()->json($response);
    }

    public function check_slug(Request $request)
    {
        $check = Article::where('title', $request->name)->first();
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

    public function create_category(Request $request)
    {
        $categories = Category::where('category', $request->new_cat)->first();
        if(isset($categories) && $categories != null && $categories != '')
        {
            return response()->json(['status' => '1', 'message' => 'Category is already exists!']);
        }
        $slug = Str::slug($request->new_cat);
        $new_cat = new Category();
        $new_cat->category = $request->new_cat;
        $new_cat->slug = $slug;
        $new_cat->parent_category = isset($request->parent) ? $request->parent : '' ;
        $new_cat->save();
        if($new_cat)
        {
            return response()->json(['status' => '0', 'message' => 'Category added successfully', 'newCategory' => $new_cat]);
        }

    }
    public function create_tag(Request $request)
    {
        $tags = Tags::where('name', $request->new_tag)->first();
        if(isset($tags) && $tags != null && $tags != '')
        {
            return response()->json(['status' => '1', 'message' => 'Tag is already exists!']);
        }
        $tag_slug = Str::slug($request->new_tag);
        $new_tag = new Tags();
        $new_tag->name = $request->new_tag;
        $new_tag->slug = $tag_slug;
        $new_tag->save();
        if($new_tag)
        {
            return response()->json(['status' => '0', 'message' => 'Tag added successfully', 'newtag' => $new_tag]);
        }

    }

    public function check_status(Request $request)
    {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Status canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['status'] = 0;
            $save = Article::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Status Update Successfully";

        } else {
            $data['status'] = 1;
            $save = Article::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Status   Update Successfully";

        }
        return response()->json($response);
    }

    public function comments_index()
    {
        return view('articles.comments');
    }
    public function comments_list(Request $request)
    {
        $deleted = false;

        if(isset($request->selected) && $request->selected == 'approved')
        {
            $comment_list = Comment::where('approved_status', 1)->where('spam_status', 0)->latest()->get();

        }else if(isset($request->selected) && $request->selected == 'not_approved')
        {
            $comment_list = Comment::where('approved_status', 0)->latest()->get();

        }else if(isset($request->selected) && $request->selected == 'spam')
        {
            $comment_list = Comment::where('spam_status', 1)->latest()->get();

        }else if(isset($request->selected) && $request->selected == 'trashed')
        {
            $comment_list = Comment::withTrashed()->whereNotNull('deleted_at')->latest()->get();
            $deleted = true;
        }
        $counter = 1;
        $comment_list->transform(function ($item) use (&$counter, $deleted) {
            $item['ser_id'] = $counter++;
            $item['author'] = '<div class="d-flex align-itmes-center vtop">
            <div class="d-inline">
            <img src="' . asset('assets/img/new-profile.svg') . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;">
            </div>
            <div class="d-inline-block ml-1">
            <span>'.(isset($item->user_name) ? $item->user_name : $item->article->author_name->name).'</span>
            <br>
            <a href="javascript:void(0)" class="text-primary">'.(isset($item->user_email) ? $item->user_email : '').'</a>
            <br>
            </div>
            </div>';
             if ($item->parent_id !== null) {
                $parentComment = Comment::find($item->parent_id);
                if ($parentComment) {
                    $item['parent_user_name'] = $parentComment->user_name;
                }
             }else{
                $item['parent_user_name'] = '';
             }
            $item['comment'] = '
            <span class="d-block mb-2 reply_user_name">'.(isset($item['parent_user_name']) && $item['parent_user_name'] !== '' ? 'In Reply to <a href="javascript:void(0)">' . $item['parent_user_name'] : '').'</a></span>
            <span class="d-block mb-2">'.(isset($item->comment) ? $item->comment : '').'</span>';
            if(isset($deleted) && $deleted == false)
            {
                $item['comment'] .= '<div class="comments_buttons row pl-3">
            <a href="javascript:void(0)" class="text-primary p-0 change_status" data-id="'.(isset($item->id) ? $item->id : '').'" data-status="'.(isset($item->approved_status) ? $item->approved_status : '').'" data-val="approved">' . ($item->approved_status == 1 ? 'Unapprove' : 'Approve') . ' |</a>
            <a href="javascript:void(0)" class="text-danger p-0 change_status" data-id="'.(isset($item->id) ? $item->id : '').'" data-status="'.(isset($item->spam_status) ? $item->spam_status : '').'" data-val="spam">Spam |</a>
            <a href="javascript:void(0)" class="text-danger p-0 change_status" data-id="'.(isset($item->id) ? $item->id : '').'" data-status="2" data-val="trash">Trash</a>
            </div>';
            }
            $item['response'] = '<div class="d-inline-block pl-1">
            <a href="'.route('articles.edit', ['id' => $item->article->id]).'" target="_blank" class="text-primary d-block mb-1">'.(isset($item->article->title) ? $item->article->title : '').'</a>
            <a href="javascript:void(0)" class="text-primary d-block mb-3">View Blog</a>
            </div>';
            $updated_at = Carbon::parse($item['updated_at']);
            $formatted_date = $updated_at->format('Y/m/d \a\t h:i a');

            $item['submit'] = isset($formatted_date) ? $formatted_date: '-';
            return $item;

        });
    
        return response()->json(['data' => $comment_list]);
    }

    public function comments_status_change(Request $request)
    {
        $id = $request->id;
        // dd($request->all());
        if (isset($request->status) && $request->val == 'approved') {
            $data['approved_status'] = isset($request->status) && $request->status == '0' ? 1 : 0;
            $save = Comment::where('id', $id)->update($data);
            $response['message'] = "Comment Approved Status changed.";
            $response['status'] = 1;

        } else if(isset($request->status) && $request->val == 'spam'){
            $data['spam_status'] = isset($request->status) && $request->status == '0' ? 1 : 0;
            $save = Comment::where('id', $id)->update($data);
            $response['message'] = "Comment added as Spam.";
            $response['status'] = 1;

        }else if(isset($request->status) && $request->status == '2' && $request->val == 'trash'){
            $comment = Comment::findOrfail($id);
            $comment->delete();
            $response['message'] = "Comment deleted successfully";
            $response['status'] = 2;
        }else{
            $response['message'] = "Something Went Wrong!";
            $response['status'] = 3;
        }
        return response()->json($response);
    }
}