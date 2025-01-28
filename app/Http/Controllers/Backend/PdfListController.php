<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PdfList;
use App\Models\MediaSection;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use DateTime;

class PdfListController extends Controller
{
    public function index($slug)
    {
        $sec_title = MediaSection::where('slug',$slug)->first();
        return view('pdflist.index',compact('slug','sec_title'));
    }
    public function save(Request $request)
    {
        // dd($request->all());
        if(isset($request->pdf_id) && $request->pdf_id != null && $request->pdf_id != '')
        {
            $pdf_file = PdfList::findOrfail($request->pdf_id);
        }else{
            $pdf_file = new PdfList();
        }
        if ($request->hasFile('pdf')) {
            if(isset($request->old_pdf) && $request->old_pdf != '')
            {
                $file_path = public_path('uploads/pdf_file/' . $request->old_pdf);
                if (File::exists(public_path('uploads/pdf_file/' . $request->old_pdf))) {
                    File::delete($file_path);
                }
            }
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf = $request->file('pdf');
            $pdf = $current . $uploadpdf->getClientOriginalName();
            $uploadpdf->move('uploads/pdf_file/', $pdf);
        }else{
            $pdf = $request->old_pdf;
        }
        if ($request->hasFile('cover_image')) {
            $file_path = public_path('uploads/media/' . $request->cover_old_img);
                if (File::exists(public_path('uploads/media/' . $request->cover_old_img))) {
                    File::delete($file_path);
                }
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf = $request->file('cover_image');
            $image = $current . $uploadpdf->getClientOriginalName();
            $uploadpdf->move('uploads/media/', $image);
            $imageName = $image;
        }else{
            
            $imageName = isset($request->cover_old_img) ? $request->cover_old_img : null;
        }
        $pdf_file->title = isset($request->title) ? $request->title : null;
        $pdf_file->type = isset($request->type) ? $request->type : null;
        $pdf_file->file = isset($pdf) ? $pdf : null;
        $pdf_file->cover_image = isset($imageName) ? $imageName : null;
        $pdf_file->save();

        return redirect()->route('pdflist.index', ['slug' => $request->type])->with('success', 'Pdf File Saved Successfully');
    }

    public function list(Request $request)
    {
        $pdf_list = PdfList::where('type',$request->slug)->latest()->get();
        //  dd($pdf_list);
        $counter = 1;
        $pdf_list->transform(function ($item) use (&$counter) {

            $item['ser_id'] = $counter++;

            // $item['ser_id'] = '<div class="custom-control custom-checkbox">
            // <input type="checkbox" class="pinned_chekbox" id="pinned_chekbox" data-id="' . $item['id'] . '"';

            // if ($item['pinned'] == 1) {
            //     $item['ser_id'] .= ' checked';
            // }
            //   $item['ser_id'] .= '></div>';

            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y | h:iA');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }
            
            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured"  class="is_featured_class">';
            }
            $item['action'] = '<a href="javascript:;" class="table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click here to Edit Pdf"  ><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a href="javascript:;" data-href="' . route('pdflist.delete', $item['id']) . '" title="Click here to Delete Pdf"  class="table-btn table-btn1 delete"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';
            return $item;
        });
        return response()->json(['data' => $pdf_list]);
    }
    public function edit(Request $request)
    {
        
        $pdf_list = PdfList::findOrfail($request->id);
        // dd($pdf_list);
        if(isset($pdf_list) && $pdf_list != '' && $pdf_list != null)
        {
            $data = $pdf_list;
            return response()->json(['data' => $data , 'message' => 'success' , 'status' => 'success']);
        }else{
            return response()->json(['message' => 'something went wrong!', 'status' => 'error']);
        }
    }
    public function delete($id)
    {
        // dd($id);
        $pdf_list = PdfList::findOrfail($id);
        if(isset($pdf_list) && $pdf_list != '' && $pdf_list != null)
        {
            if(isset($pdf_list->file) && $pdf_list->file != '')
            {
                $file_path = public_path('uploads/pdf_file/' . $pdf_list->file);


                if (File::exists(public_path('uploads/pdf_file/' . $pdf_list->file))) {
                    File::delete($file_path);
                }
            }
            $slug = $pdf_list->type;
            $pdf_list->delete();
            return redirect()-> route('pdflist.index', ['slug' => $request->type])->with('error','Pdf File Deleted Successfully!');
        }else{
            return redirect()-> route('pdflist.index', ['slug' => $request->type])->with('error','something went wrong!');
        }
    }
    public function status(Request $request)
    {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Featured canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['status'] = 0;
            $save = PdfList::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Disable Successfully";

        } else {
            $data['status'] = 1;
            $save = PdfList::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Enable Successfully";

        }
        return response()->json($response);
    }
}
