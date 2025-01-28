<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MediaSection;
use App\Models\HomePageSetting;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class PageSettingController extends Controller
{
	public function index()
	{
		return view('pagesetting.index');
	}
}
