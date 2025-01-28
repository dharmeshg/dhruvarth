<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Category;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wishlist;
use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Mail;


class WishlistController extends Controller
{
	// public function deleteWishlist($id)
	// {
		


 //        $record = Wishlist::find($id);
 //        $record->delete();

 //        return redirect()->back()->with('success_message', 'Item has been removed!');
		
	// }
}