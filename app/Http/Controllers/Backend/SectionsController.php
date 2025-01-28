<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sections;
use App\Models\Article;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;


class SectionsController extends Controller
{
 
    public function index()
    {
        $sections_list = Sections::select('*')->where('deleted_at', null)->get();
        return view('sections.index')->with(compact('sections_list'));
    }


    public function save(Request $request)
    {
        $id = $request->sections_id;

        $data['title'] = isset($request->title) ? $request->title : null;
        $data['description'] = isset($request->description) ? $request->description : null;

        if ($id != '') {

            $save = Sections::where('id', $id)->update($data);

            return redirect()->intended('/admin/sections')->with('success', 'Sections successfully Update.');
        } else {
            $data['slug'] = SlugService::createSlug(Sections::class, 'slug', $request->slug);
            $save = Sections::create($data);

            return redirect()->intended('/admin/sections')->with('success', 'Sections successfully Submit.');
        }
    }

    public function delete($id)
    {
        if ($id != "") {
      
            $article = Article::where('section_id' ,$id)->where('deleted_at' ,null)->get();
            if (isset($article) && count($article) != 0) {
         
                return redirect()->intended('/admin/sections')
                ->withError('Can not delete Sections, some Articles are available for this Sections!');
            }else{
          
                $record = Sections::find($id);
                $record->delete();
                return redirect()->intended('/admin/sections')
                    ->withSuccess('Sections successfully Delete');

            }
        
        }
    }

    public function edit(Request $request) {
        $id = $request->id;
        if ($id) {
            $data = Sections::where('id', $id)->first();
            return json_encode($data);
        }
    }

    public function list() {
        $sections_list = Sections::select('*')->where('deleted_at', null)->get();
        $counter = 1;
        $sections_list->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            $item['action'] = '<a class="table-btn table-btn1 sections_edit" data-id="' . $item['id'] . '"><img src="'. asset('assets/img/edit_icon.svg') .'" class="img-fluid white_logo" alt=""></a>';
            $item['action'] .= '<a data-href="' . route('sections.delete',$item['id']) . '" data-title="testrete" data-original-title="Delete sections" class="table-btn table-btn1 sections_delete"><img src="' . asset('assets/img/delete_icon.svg') .'" class="img-fluid white_logo" alt=""></a>';
            return $item;
        });
    
        return response()->json(['data' => $sections_list]);
    }
     


}