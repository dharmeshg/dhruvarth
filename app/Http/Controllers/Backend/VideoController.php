<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Category;
use App\Models\User;
use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Video;
use App\Models\Sections;
use App\Models\Tags;
use Illuminate\Support\Facades\Storage;
use Mail;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function getVideoUploadForm()
    {
        return view('video.video-upload');
    }
    public function add()
    {
        $sections = Sections::select('*')->where('deleted_at', null)->get();
        $tags = Tags::select('*')->where('deleted_at', null)->get();
        return view('video.add',compact('sections','tags')); 
    }

public function uploadVideo(Request $request)
{
    // dd($request->all());

    $video_id = $request->video_id;

    $this->validate($request, [
        'title' => 'required',
        'short_description' => 'required',
        'content' => 'required',
        'section_id' => 'required',
        'category_id' => 'required|array', 
        'tag_id' => 'required|array', 
        'published_at' => 'nullable',
        'is_featured' => 'nullable',
        'video' => $request->input('video_option') === 'video' ? 'required|file|mimetypes:video/mp4' : 'nullable',
        'url' => $request->input('video_option') === 'url' ? 'required|url' : 'nullable',
    ]);

    if ($video_id) {
        $video = Video::find($video_id);

        if (!$video) {
            return back()->with('error', 'Video not found.');
        }
    } else {
        $video = new Video();
    }

    $video->title = $request->title;
    $video->short_description = $request->short_description;
    $video->content = $request->content;
    $video->section_id = $request->section_id;
    $video->category_id = implode(',', $request->category_id); 
    $video->tag_id = implode(',', $request->tag_id);
    $video->published_at = $request->published_at;
    $video->author = auth()->user()->id;
    $video->is_featured = $request->has('is_featured') ? true : false;

    if ($request->input('video_option') === 'video' && $request->hasFile('video')) {
        $fileName = $request->video->getClientOriginalName();
        $filePath = 'videos/' . $fileName;
        if ($video_id) {
            $video = Video::find($video_id);
            if (!$video) {
                return redirect('/admin/video-list')->with('error', 'Video not found.');
            }else{
                if($video->path != null){
                    Storage::disk('public')->delete($video->path);
                }
            }
        }
        Storage::disk('public')->put($filePath, file_get_contents($request->video));
        $video->path = $filePath;
        $video->url = null;
    } elseif ($request->input('video_option') === 'url' && $request->filled('url')) {
        $video->path = null;
        $video->url = $request->url;
    }

    $video->save();

    if ($video_id) {
        return redirect('/admin/video-list')->with('success', 'Video has been successfully updated.');
    } else {
        return redirect('/admin/video-list')->with('success', 'Video has been successfully uploaded.');
    }

    return redirect('/admin/video-list')->with('error', 'Unexpected error occurred');
}

    public function list(Request $request){

        $video_list = Video::select('videos.id','videos.url','videos.path','videos.is_featured', 'videos.title', 'videos.category_id', 'videos.section_id', 'videos.author', 
        DB::raw('GROUP_CONCAT(category.category SEPARATOR ", ") AS Cat_name'),'sections.title AS sec_name','users.name AS authorname')
        ->join('category', 'videos.category_id', 'LIKE', DB::raw('CONCAT("%", category.id, "%")'))
        ->join('sections', 'videos.section_id', '=', 'sections.id')
        ->join('users', 'videos.author', '=', 'users.id')
        ->groupBy('videos.url','videos.id','videos.path','videos.is_featured', 'videos.title', 'videos.category_id', 'videos.section_id', 'videos.author','sections.title', 'users.name')
        ->get();
    
        $counter = 1;   
        $video_list->transform(function ($item) use (&$counter) {
            
            $item['no'] = $counter++;
            $item['path'] = $item['path'];
            $item['author'] = $item['authorname'];
            $item['section'] = $item['sec_name'];
            $item['category'] = $item['Cat_name'];
            if($item['is_featured'] == '1')
            {
                $item['featured'] ='<input type="checkbox" name="is_featured" checked>'; 
            }else{
                $item['featured'] ='<input type="checkbox" name="is_featured">';
            }
            
            $item['action'] = '<a class="table-btn table-btn1 video_edit" data-id="' . $item['id'] . '" href="' .route('videos.edit',$item['id']).'"><img src="'. asset('assets/img/edit_icon.svg') .'" class="img-fluid white_logo" alt=""></a>';
            $item['action'] .= '<a data-href="' . route('videos.delete',$item['id']) . '" data-title="testrete" data-original-title="Delete sections" class="table-btn table-btn1 video_delete"><img src="' . asset('assets/img/delete_icon.svg') .'" class="img-fluid white_logo" alt=""></a>';
            return $item;
        });
    
        return response()->json(['data' => $video_list]);
    }

    public function edit($id) {
        $video = Video::findOrFail($id);
        // if(isset($video->url) && $video->url != null){
        //     $embed = Embed::parseUrl($video->url);
        // }
        $sections = Sections::select('*')->where('deleted_at', null)->get();
        $tags = Tags::select('*')->where('deleted_at', null)->get();
        $categories = Category::where('sections_id', $video->section_id)->get();
        // if(isset($video->url) && $video->url != null){
        //     return view('video.add',compact('video','sections','tags','categories','embed'));
        // }
        return view('video.add',compact('video','sections','tags','categories'));
    }

    public function deleteVideo($id)
    {
        $video = Video::find($id);
        if (!$video) {
            return back()->with('error', 'Video not found.');
        }

        if($video->path != null){
            Storage::disk('public')->delete($video->path);
        }

        $video->delete();

        return back()->with('success', 'Video has been successfully deleted.');
    }

    public function delete(Request $request)
    {
        $videoId = $request->input('videoId');
        $urlId =$request->input('urlId');
        if ($videoId) {
            $video = Video::find($videoId);
            if (!$video) {
                return response()->json(['status' => 'error','message' => 'Video not found.'], 404);
            }else{
                try {
                    Storage::disk('public')->delete($video->path);
                    $video->path = null;
                    $video->save();
                    return response()->json(['status' => 'success','message' => 'Video deleted successfully.']);
                } catch (\Exception $e) {
                    return response()->json(['status' => 'error','message' => 'Failed to delete video.'], 500);
                }
            }
        }
        if($urlId){
            $video = Video::find($urlId);
            if (!$video) {
                return response()->json(['status' => 'error','message' => 'URL not found.'], 404);
            }else{
                try {
                    $video->url = null;
                    $video->save();
                    return response()->json(['status' => 'success','message' => 'URL deleted successfully.']);
                } catch (\Exception $e) {
                    return response()->json(['status' => 'error','message' => 'Failed to delete URL.'], 500);
                }
            }
        }
        return response()->json(['status' => 'error','message' => 'Invalid request.'], 400);
    }
}