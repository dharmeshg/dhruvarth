<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AccessControlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $setting = Setting::first();
        if (isset($setting->access_login_mandatory) && $setting->access_login_mandatory == 1 && !Auth::check()) {
            if (!session()->has('redirected')) {
                session(['redirected' => true]);
                return redirect()->route('home')->with('showLoginPopup', true);
            }
        }
        if(Auth::check())
        {
            $user = Auth::user();
            if(isset($user->role) && $user->role != 'administrator')
            {
                if((isset($user->site_access) && $user->site_access != null && $user->site_access == 1) && (isset($setting->access_limited_access) && $setting->access_limited_access != null && $setting->access_limited_access == 1))
                {
                    // dd($user);
                    $startDateTime = Carbon::createFromFormat('m/d/Y H:i', $user->site_access_start_date . ' ' . $user->site_access_start_time);
                    $endDateTime = Carbon::createFromFormat('m/d/Y H:i', $user->site_access_end_date . ' ' . $user->site_access_end_time);
                    $currentDateTime = Carbon::now();
                    if ($currentDateTime->between($startDateTime, $endDateTime)) {
                        return $next($request);
                    } else {
                        if (!session()->has('access_expired')) {
                            session(['access_expired' => true]);
                            // Auth::logout();
                            return redirect()->route('home')->with('showexpiredalert', true);
                        }
                    }
                }
            }else if(isset($user->role) && $user->role == 'administrator')
            {
                if (!session()->has('access_expired')) {
                    session(['access_expired' => true]);
                    // Auth::logout();
                    return redirect()->route('home')->with('showexpiredalert', true);
                }
            }
            
        }
        session()->forget('access_expired');
        session()->forget('redirected');
        return $next($request);
    }
}
