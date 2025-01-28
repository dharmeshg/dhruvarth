<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        return view('team.index');
    }
    
    public function add()
    {
        return view('team.add');
    }
}
