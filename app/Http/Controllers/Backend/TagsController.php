<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tags;
use App\Models\Article;
use Cviebrock\EloquentSluggable\Services\SlugService;

class TagsController extends Controller
{
    public function index()
    {
        // $tags_list = Tags::select('*')->where('deleted_at', null)->get();
        return view('tags.index');
    }

    public function save(Request $request)
    {
        $id = $request->tags_id;

        if ($id != '') {
            $tag = Tags::findOrfail($id);
            $tag->name = isset($request->name) ? $request->name : null;
            $tag->description = isset($request->description) ? $request->description : null;
            $tag->update();

            return redirect()->route('tags')->with('success', 'Tags successfully Update.');
        } else {
            $slug = SlugService::createSlug(Tags::class, 'slug', $request->slug);
            $tag = new Tags();
            $tag->slug = $slug;
            $tag->name = isset($request->name) ? $request->name : null;
            $tag->description = isset($request->description) ? $request->description : null;
            $tag->save();

            return redirect()->route('tags')->with('success', 'Tags successfully Submit.');
        }
    }

    public function delete($id)
    {
        if ($id != "") {
            $articles = Article::where('deleted_at', null)
                ->where('tag_id', 'like', '%' . $id . '%')
                ->get();

            if (isset($articles) && count($articles) != 0) {
                return redirect()->route('tags')
                ->withError('Can not delete Tags, some Articles are available for this Tags!');
            } else {
                $record = Tags::find($id);
                $record->delete();
                return redirect()->route('tags')
                    ->withSuccess('Tags successfully Delete');
            }

        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $data = Tags::where('id', $id)->first();
            return json_encode($data);
        }
    }


    public function list()
    {
        $tags_list = Tags::select('*')->where('deleted_at', null)->get();
        $counter = 1;
        $tags_list->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '"  id="is_featured" name="is_featured" checked>';
            } else {
                $item['status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '" id="is_featured" name="is_featured">';
            }
            $item['action'] = '<a class="label theme-bg2 text-white f-12 table-btn table-btn1 tags_edit" data-id="' . $item['id'] . '"><i class="fa fa-edit"></i></a>';
            $item['action'] .= '<a data-href="' . route('tags.delete', $item['id']) . '" data-title="testrete" data-original-title="Delete Tags" class="label theme-bg text-white f-12 table-btn table-btn1 tags_delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            return $item;
        });

        return response()->json(['data' => $tags_list]);
    }

    public function check_featured(Request $request)
    {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Featured canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['status'] = 0;
            $save = Tags::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Tag Disabled Successfully";

        } else {
            $data['status'] = 1;
            $save = Tags::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Tag Enabled Successfully";

        }
        return response()->json($response);
    }

    public function check_slug(Request $request)
    {
        $check = Tags::where('name', $request->name)->first();
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
}