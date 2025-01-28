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
use Mail;


class UserController extends Controller
{
    public function index() {
        // $user = User::where('role','!=','admin')->get();
        return view('user.add');
    }
    public function generate(Request $request)
    {
        $password = Str::random(12);
        return response()->json(['password' => $password]);
    }

    public function save(Request $request) {
        $user_id = $request->user_id;
        $auth_user = null;
        if($user_id !== null || $user_id !== ''){
            $auth_user=User::find($user_id);
        }
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required','email',Rule::unique('users')->ignore($auth_user ? $auth_user->id : null)],
            'phone' => 'nullable|max:255',
            'website' => 'nullable|url|max:255',
            'role' => 'required|string|max:255',
        ];

        if ($user_id === null && $user_id === '') {
            $rules['password'] = 'required|min:6';
        }else{
            $rules['password'] = 'nullable';
        }
        $validatedData = $request->validate($rules);

        if ($request->has('password') && $request->input('password') !== null) {
            $validatedData['password'] = Hash::make($request->input('password'));
        }
        if ($user_id === null || $user_id === '') {
            $user = User::create($validatedData);
            if($request->notify === "on"){
                Mail::to($user->email)->send(new NotifyMail($user));
            }
            return redirect()->intended('/admin/users')
                            ->withSuccess('User Added Successfully');
        }else{
            if ($request->input('password') === null) {
                unset($validatedData['password']);
            }
            $user = User::where('id', $user_id)->update($validatedData);
            return redirect()->intended('/admin/users')
                            ->withSuccess('User Edited Successfully');
        }
    }
    public function delete($id) {
        if ($id !== "" && $id !== null) {
           User::where('id', $id)->delete();
           return redirect()->intended('/admin/users')
           ->withSuccess('User Deleted');
        }
    }

    public function edit(Request $request) {
        $id = $request->id;
        if ($id) {
            $data = User::where('id', $id)->first();
            return json_encode($data);
        }
    }

    public function list() {
        $user = User::where('role','!=','admin')->get();
    
        $counter = 1;
        $user->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            $item['action'] = '<a class="label theme-bg2 text-white f-12 table-btn table-btn1 edit" data-id="' . $item['id'] . '"><i class="fa fa-edit"></i></a>';
            $item['action'] .= '<a data-href="' . route('users.delete',$item['id']) . '" data-title="testrete" data-original-title="Delete user" class="label theme-bg text-white f-12 table-btn table-btn1 delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            return $item;
        });
    
        return response()->json(['data' => $user]);
    }


}
