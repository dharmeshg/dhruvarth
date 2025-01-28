<?php 

namespace App\Http\Middleware; 
use Closure; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Session; 

class PreventBackToOrderForm { 

public function handle(Request $request, Closure $next) { 
	
	// if (Session::has('order_submitted')) { // Order already submitted, redirect to confirmation page 
	// 	return redirect()->route('confirmation');
	// } 

	if($request->route()->getActionName() == 'App\Http\Controllers\Frontend\OrderController@order_details'){
			return redirect()->route('front.cart');
	}

	return $next($request); 
	} 
}