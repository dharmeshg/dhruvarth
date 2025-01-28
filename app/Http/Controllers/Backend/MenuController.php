<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\EmailSetting;
use App\Models\Slider;
use App\Models\MediaImage;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Article;
use App\Models\Page;
use App\Models\Menu_list;
use App\Models\Married;
use App\Models\ProductService;
use App\Models\Updatelog;





use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

class MenuController extends Controller
{
    public function index()
    {
        return view('menu.index');
    }

    public function add(Request $request)
    {
        if (isset($request->edit_main_menu) && $request->edit_main_menu != '') {
            $menu = Menu::find($request->edit_main_menu);
        }else{
            $menu = new Menu();
        }
        

        $menu->display_location = isset($request->menu_name) ? $request->menu_name : '';
        $menu->header_menu = isset($request->header) ? 1 : 0;
        $menu->footre_quick_links = isset($request->quick_links) ? 1 : 0;
        $menu->footre_services = isset($request->services) ? 1 : 0;


        $menu->save();
        return redirect()->route('menu.index')->with('success','Menu Added Successfully.');

    }

    public function store(){

        $menu_list = Menu::select('*')->where('deleted_at', null)->get();

        $counter = 1;
        $menu_list->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
        
            if ($item['header_menu'] == '1') {
                $item['header_menu'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="header_menu" name="header_menu" data-val="header_menu"  checked class="display_menu is_featured_class">';
            } else {
                $item['header_menu'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="header_menu"  class="display_menu is_featured_class" name="header_menu" data-val="header_menu">';
            }

            if ($item['footre_quick_links'] == '1') {
                $item['footre_quick_links'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="footre_quick_links" name="footre_quick_links"  checked class="display_menu is_featured_class" data-val="footre_quick_links">';
            } else {
                $item['footre_quick_links'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="footre_quick_links"  class="display_menu is_featured_class" name="footre_quick_links" data-val="footre_quick_links">';
            }

            if ($item['footre_services'] == '1') {
                $item['footre_services'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="footre_services" name="footre_services"  checked class="display_menu is_featured_class" data-val="footre_services">';
            } else {
                $item['footre_services'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="footre_services"  class="display_menu is_featured_class" name="footre_services" data-val="footre_services">';
            }
            $item['action'] = '<a class="label theme-bg2 text-white f-12 tags_edit" data-id="' . $item['id'] . '" href="' . route('menu.edit', $item['id']) . '"><i class="fa fa-edit"></i></a>';
            $item['action'] .= '<a data-href="' . route('menu.delete', $item['id']) . '" data-title="testrete" data-original-title="Delete Tags" class="label theme-bg text-white f-12 menu_delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            return $item;

        });
    
        return response()->json(['data' => $menu_list]);

    }

    public function delete($id)
    {
          if ($id != "") {
            $record = Menu::find($id);
            $record->delete();
            return redirect()->route('menu.index')
                ->withSuccess('Menu Delete Successfully.');
        }
    }

    public function display_location(Request $request)
    {
           $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Display Location canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            if ($request->display_location == 'footre_quick_links') {
                 $data['footre_quick_links'] = 0;
            }elseif ($request->display_location == 'header_menu') {
                $data['header_menu'] = 0;
            }elseif ($request->display_location == 'footre_services') {
                $data['footre_services'] = 0;
            }
            $save = Menu::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Display Location Update Successfully";

        } else {
             if ($request->display_location == 'footre_quick_links') {
                 $data['footre_quick_links'] = 1;
            }elseif ($request->display_location == 'header_menu') {
                $data['header_menu'] = 1;
            }elseif ($request->display_location == 'footre_services') {
                $data['footre_services'] = 1;
            }
            $save = Menu::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Display Location Update Successfully";

        }
        return response()->json($response);
    }

    public function edit($id)
    {
        $menus = Menu::find($id);
        $category = Category::select('*')->where('deleted_at', null)->get();
        $posts = Article::select('*')->where('deleted_at', null)->get();
        $pages = Page::select('*')->where('deleted_at', null)->get();
        $service = ProductService::select('*')->where('deleted_at', null)->get();
        $married = Married::select('*')->where('deleted_at', null)->get();

        $menu_lists = Menu_list::with('children')->whereNull('parent_id')->where('menus_id', $id)->get();

        return view('menu.add', compact('menus', 'category', 'posts', 'pages', 'menu_lists', 'service', 'married'));
    }

    public function edit_menu(Request $request)
    {
        $menu_list = $request->input('nestedData');

        $menu_id = $request->id;
        $check_menu_lists = Menu_list::where('menus_id', $menu_id)->get();
        $edata = json_encode($check_menu_lists);
        $edt = Updatelog::create(['tablename'=>'menu','table_primary_id'=>$menu_id,'edit_log'=>$edata]);
        if (isset($check_menu_lists) && count($check_menu_lists)) {
            Menu_list::where('menus_id', $menu_id)->delete();
        }

        $this->saveMenuItems($menu_list, $menu_id);
        $response['status'] = 1;
        $response['message'] = "Menu Added Successfully.";
        
        return response()->json($response);
    }

    public function saveMenuItems($menu_list, $menu_id, $parentId = null)
    {
        $menu_ids = $menu_id;

         foreach ($menu_list as $key => $menu) {

            if (isset($menu['deleted']) && $menu['deleted'] == "0") {
                 $record = new Menu_list();
                $record->menus_id = $menu_ids;
                $record->name = $menu['name'];
                $record->slug = $menu['slug'];
                $record->parent_id = $parentId;
                $record->save();

                if (!empty($menu['children'])) {
                    $this->saveMenuItems($menu['children'], $menu_ids, $record->id);
                }
            }
          
          
        }
    }


  
}
