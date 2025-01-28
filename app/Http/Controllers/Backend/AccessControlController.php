<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class AccessControlController extends Controller
{
    public function dashboard()
    {
        return view('accesscontrol.dashboard');
    }
    public function index()
    {
        $access = Setting::first();
        return view('accesscontrol.index',compact('access'));
    }
    public function save(Request $request)
    {
        $access = Setting::first();
        $access->access_login_optional = isset($request->access_login_optional) && $request->access_login_optional == 'on' ? 1 : 0;
        $access->access_login_mandatory = isset($request->access_login_mandatory) && $request->access_login_mandatory == 'on' ? 1 : 0;
        $access->access_unlimited_access = isset($request->access_unlimited_access) && $request->access_unlimited_access == 'on' ? 1 : 0;
        $access->access_limited_access = isset($request->access_limited_access) && $request->access_limited_access == 'on' ? 1 : 0;
        $access->approval_for_login = isset($request->approval_for_login) && $request->approval_for_login == 'on' ? 1 : 0;
        if(isset($request->access_limited_access) && $request->access_limited_access == 'on')
        {
            $access->global_access_hours = isset($request->global_access_hours) ? $request->global_access_hours : null;
            $access->global_access_min = isset($request->global_access_min) ? $request->global_access_min : null;
        }
        $access->save();
        return redirect()->route('accesscontrole.index')->with('success','Access Control Setting Saved Successfully.');
    }
}
