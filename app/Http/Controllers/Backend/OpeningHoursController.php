<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Redirect;
use Illuminate\Support\Str;
use App\Models\OpeningHours;




class OpeningHoursController extends Controller
{
    public function index()
    {
        $opening_hours = OpeningHours::get();
        return view('opening_hours.index')->with(compact('opening_hours'));
    }

    public function save(Request $request)
    {

        if (isset($request->monday_form) && $request->monday_form != '' && isset($request->monday_to) && $request->monday_to != '') {

            $opening_hours = OpeningHours::findOrfail('1');
            $opening_hours->from = $request->monday_form;
            $opening_hours->to = $request->monday_to;
            $opening_hours->update();
        }

         if (isset($request->tuesday_form) && $request->tuesday_form != '' && isset($request->tuesday_to) && $request->tuesday_to != '') {

            $opening_hours = OpeningHours::findOrfail('2');
            $opening_hours->from = $request->tuesday_form;
            $opening_hours->to = $request->tuesday_to;
            $opening_hours->update();
        }

         if (isset($request->wednesday_form) && $request->wednesday_form != '' && isset($request->wednesday_to) && $request->wednesday_to != '') {

            $opening_hours = OpeningHours::findOrfail('3');
            $opening_hours->from = $request->wednesday_form;
            $opening_hours->to = $request->wednesday_to;
            $opening_hours->update();
        }

         if (isset($request->thursday_form) && $request->thursday_form != '' && isset($request->thursday_to) && $request->thursday_to != '') {

            $opening_hours = OpeningHours::findOrfail('4');
            $opening_hours->from = $request->thursday_form;
            $opening_hours->to = $request->thursday_to;
            $opening_hours->update();
        }

         if (isset($request->friday_form) && $request->friday_form != '' && isset($request->friday_to) && $request->friday_to != '') {

            $opening_hours = OpeningHours::findOrfail('5');
            $opening_hours->from = $request->friday_form;
            $opening_hours->to = $request->friday_to;
            $opening_hours->update();
        }

         if (isset($request->saturday_form) && $request->saturday_form != '' && isset($request->saturday_to) && $request->saturday_to != '') {

            $opening_hours = OpeningHours::findOrfail('6');
            $opening_hours->from = $request->saturday_form;
            $opening_hours->to = $request->saturday_to;
            $opening_hours->update();
        }

         if (isset($request->sunday_form) && $request->sunday_form != '' && isset($request->sunday_to) && $request->sunday_to != '') {

            $opening_hours = OpeningHours::findOrfail('7');
            $opening_hours->from = $request->sunday_form;
            $opening_hours->to = $request->sunday_to;
            $opening_hours->update();
        }

            return redirect()->route('opening_hours.index')->with('success', 'Opening Hours successfully Update.');
      

    }

   
    public function list()
    {
        $direction_link_list = OpeningHours::get();

        $counter = 1;
        $direction_link_list->transform(function ($item) use (&$counter) {

            $item['ser_id'] = $counter++;

            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '"  id="is_featured" name="is_featured" checked>';
            } else {
                $item['status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '" id="is_featured" name="is_featured">';
            }

             if (isset($item->from) && $item->from != "" && isset($item->to) && $item->to != "") {
                $timeForm = $item->from;
                $timestampForm = strtotime($timeForm);
                $formattedTimeForm = date("h:i A", $timestampForm);
                $timeTo = $item->to;
                $timestampTo = strtotime($timeTo);
                $formattedTimeTo = date("h:i A", $timestampTo);
                $item['time'] = $formattedTimeForm ." To " . $formattedTimeTo;
            } else {
                $item['time'] = "Closed";
            }
     
            return $item;
        });

        return response()->json(['data' => $direction_link_list]);
    }

      public function check_featured(Request $request)
    {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Featured canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['status'] = 0;
            $save = OpeningHours::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Close Successfully";

        } else {
            $data['status'] = 1;
            $save = OpeningHours::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Open Successfully";

        }
        return response()->json($response);
    }

   
}