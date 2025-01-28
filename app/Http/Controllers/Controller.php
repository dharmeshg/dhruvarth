<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\BusinessSetting;
use App\Models\Citie;
use App\Models\Category;
use App\Models\Country;
use App\Models\State;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

     public function getBusinessData()
    {
        $business_details = BusinessSetting::first();
        $categories = Category::all();
        if ($business_details && $business_details->city) {
            $city = Citie::where('id', $business_details->city)->first();
            if ($city) {
                $business_details->city = $city->name;
            }
        }
        if ($business_details && $business_details->country) {
            $country = Country::where('id', $business_details->country)->first();
            if ($city) {
                $business_details->country = $country->name;
            }        }
        if ($business_details && $business_details->state) {
            $state = State::where('id', $business_details->state)->first();
            if ($city) {
                $business_details->state = $state->name;
            }
        }
        $categoryNames = $categories->pluck('category')->implode(', ');
        
        // $business_details->primary_category = 'Antique Jewelry';
        // $business_details->secondary_category = 'CZ Jewelry, Diamond Jewelry, Enamel Jewelry, Gemstones, Gold Jewelry, Jadtar Jewelry, Kundan Jewelry, One Gram Gold Jewelry, Platinum Jewelry, Silver Jewelry';
        // $business_details->nature_of_business = 'Manufacturer, Showroom, Wholesaler';
        $business_details->category = $business_details->primary_category;

        return $business_details;
    }
}
