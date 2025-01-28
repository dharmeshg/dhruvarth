<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Catalogue;
use App\Models\Collection;
use App\Models\Page;
use App\Models\Visitor;
use App\Models\Testimonial;
use App\Models\ProductService;
use Illuminate\Support\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        $total_products = Product::count();
        $total_gemstone = Product::where('p_category',9)->count();
        $total_catalog = Catalogue::count();
        $total_collection = Collection::count();
        $products = Product::with('category')->latest()->take(10)->get();
        return view('dashboard.dashboard',compact('total_products','total_gemstone','total_catalog','total_collection','products'));
    }
    public function get_chart(Request $request)
    {
        $endDate = Carbon::now();
        $labels = [];
        $visitorData = [];

        if(isset($request->type) && $request->type == 'monthly')
        {
            $startDate = $endDate->copy()->subMonths(11);

            for ($date = $startDate; $date->lte($endDate); $date->addMonth()) {
                $labels[] = $date->format('M Y'); 
            }
            foreach ($labels as $formattedMonth) {
                $carbonDate = Carbon::createFromFormat('M Y', $formattedMonth);
                $visitors = Visitor::whereYear('created_at', $carbonDate->year)
                    ->whereMonth('created_at', $carbonDate->month)
                    ->get()->count();
                $visitorData[] = $visitors;
            }
        }
        if(isset($request->type) && $request->type == 'daily')
        {
            $startDate = $endDate->copy()->subDays(29);

            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $formattedDates[] = $date->format('d M Y'); 
            }
            foreach ($formattedDates as $formattedDate) {
                $carbonDate = Carbon::createFromFormat('d M Y', $formattedDate);
                $visitors = Visitor::whereDate('created_at', $carbonDate->toDateString())->get()->count();
                $visitorData[] = $visitors;
            }
            $labels = array_map(function ($date) {
                return Carbon::createFromFormat('d M Y', $date)->format('d M');
            }, $formattedDates);

        }
        return response()->json(['labels' => $labels, 'data' => $visitorData]);
    }
}
