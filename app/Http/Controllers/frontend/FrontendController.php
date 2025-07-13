<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomizeProduct;
use App\Models\Manufacture;use App\Models\OrderItem;use App\Models\Partner;use App\Models\Product;
use App\Models\ProductReview;
use App\Models\SiteSetting;
use App\Models\Wishlist;use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;use function Ramsey\Uuid\v1;

class FrontendController extends Controller
{
    public function index()
    {
        $newArrivalProducts = Product::where('is_new_arrival', 1)
            ->where('status', 1)
            ->whereNotNull('available_stock')
            ->where('available_stock', '>', 0)
            ->latest()
            ->limit(16)
            ->get();



        $partner = Partner::Where('status', 1)->get();
        $userWishlist = [];
        if (Auth::check()) {
            $userWishlist = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
        }


        $siteSetting = SiteSetting::first();
        return view('user.dashboard',compact('newArrivalProducts','partner','userWishlist','siteSetting'));
    }
}
