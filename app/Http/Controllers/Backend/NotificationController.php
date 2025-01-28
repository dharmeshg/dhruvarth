<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use DateTime;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::first();

        return view('notification.index',compact('notifications'));
    }

    public function save(Request $request)
    {

        if (isset($request->notification_id) && $request->notification_id != "") {
            $notifications = Notification::findOrfail($request->notification_id);
        }else{
            $notifications = new Notification();
        }

        $notifications->title = isset($request->title) ? $request->title : null;
        $notifications->link = isset($request->link) ? $request->link : null;
        $notifications->content = isset($request->content) ? $request->content : null;
        $notifications->display = isset($request->display) ? $request->display : null;
        $notifications->status = isset($request->status) && $request->status == 'on' ? 1 : 0;
        

        $notifications->save();

        return redirect()->route('notification.index')->with('success','Notification Update Successfully.');
    }
   
}
