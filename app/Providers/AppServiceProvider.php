<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\EmailSetting;
use App\Models\BusinessSetting;
use App\Models\MetalRate;
use App\Models\PromoCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

use Config;
use Illuminate\Pagination\Paginator;
use Request;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $settings = BusinessSetting::first();
        $display_pg = 0;
        $notification = Notification::where('status',1)->first();
        if(isset($notification) && $notification != null){
            $display_pg = 0;
            $all_pages = $notification->display;
            if($all_pages == 'all'){
                $display_pg = 1;
            }
            else{
                if(Request::is('/')){
                    $display_pg = 1;
                }
            }
        }

         $metal_rate_pinned = MetalRate::where('pinned',1)->where('status', 1)->get();
         $today = Carbon::today()->format('m/d/Y');
         $public_promocodes = PromoCode::where('publish_status', 'yes')
                ->where('status', 'active')
                ->where(DB::raw('STR_TO_DATE("' . $today . '", "%m/%d/%Y")'), '>=', DB::raw('STR_TO_DATE(startDate, "%m/%d/%Y")'))
                ->where(DB::raw('STR_TO_DATE("' . $today . '", "%m/%d/%Y")'), '<=', DB::raw('STR_TO_DATE(endDate, "%m/%d/%Y")'))
                ->get();
            // $mailsetting = EmailSetting::first();
            // if($mailsetting){
            //     $data = [
            //         'driver'            => $mailsetting->transport,
            //         'host'              => $mailsetting->host,
            //         'port'              => $mailsetting->port,
            //         'encryption'        => $mailsetting->encryption,
            //         'username'          => $mailsetting->username,
            //         'password'          => $mailsetting->password,
            //         'from'              => [
            //             'address'=>$mailsetting->from_address,
            //             'name'   => $mailsetting->from_name
            //         ]
            //     ];
            //     Config::set('mail',$data);
            // }
            Paginator::useBootstrap();
            view()->share('bs', $settings);
            view()->share('mr', $metal_rate_pinned);
            view()->share('display_pg', $display_pg);
            view()->share('public_promocodes', $public_promocodes);
            libxml_disable_entity_loader(true);
            
        
    }
}
