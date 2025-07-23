<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CustomizeProduct;
use App\Models\Product;
use App\Models\ProductCrossReference;
use App\Models\ProductReview;
use App\Models\SiteSetting;
use App\Models\Wishlist;use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;use function Ramsey\Uuid\v1;

class ProductManageController extends Controller
{

    public function allProducts(Request $request, $category = null)
    {
        $categories = Category::where('status', 1)->get();
        $query = Product::where('status', 1);

        // Handle search query
        $search = $request->query('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('crossReferences', function($q) use ($search) {
                        $q->where('part_number', 'like', '%' . $search . '%');
                    });
            });
        }

        // Handle category filter
        if ($category) {
            $query->where('category_id', $category);
        }

        $limit = $request->get('limit', 12);
        $products = $query->latest()->paginate($limit)->appends($request->query());

        $userWishlist = [];
        if (Auth::check()) {
            $userWishlist = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
        }

        return view('user.pages.product.product', compact('categories', 'products', 'category', 'userWishlist', 'search'));
    }

    public function searchSuggestions(Request $request)
    {
        $search = $request->query('term');

        if (!$search) {
            return response()->json(['results' => []]);
        }

        // 1. Search products by name
        $products = Product::where('name', 'like', '%' . $search . '%')
            ->where('status', 1)
            ->select('name as text', 'id')
            ->limit(5)
            ->get();

        // 2. Search part numbers (only those matching term)
        $matchingReferences = ProductCrossReference::where('part_number', 'like', '%' . $search . '%')
            ->with(['product' => function($query) {
                $query->where('status', 1)->select('id', 'name');
            }])
            ->get();

        // 3. Map only the matched part_number for each result
        $partNumberResults = $matchingReferences->map(function($ref) {
            $product = $ref->product;
            if (!$product) return null;

            return [
                'text' => $product->name,
                'id' => $product->id,
                'part_numbers' => [$ref->part_number],
                'company_names' => [$ref->company_name]
            ];
        })->filter(); // Remove null values

        // 4. Combine both product name matches & part number matches
        return response()->json([
            'results' => $products->concat($partNumberResults)->values()
        ]);
    }



    public function productDetails($id)
    {
        $product = Product::where('id',$id)->with('category','brand','specifications','crossReferences')->first();
        //dd($product);
        $userWishlist = [];
        if (Auth::check()) {
            $userWishlist = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
        }
        $siteSetting = SiteSetting::first();
        return view('user.pages.product.productDetails',compact('product','userWishlist','siteSetting'));

    }


    public function categoryWiseProduct(Request $request, $slug = null)
    {
        if (!$slug) {
            abort(404, 'Category not found');
        }

        $category = Category::where('slug', $slug)
            ->orWhere('id', $slug) // optional: allow ID-based access
            ->firstOrFail();


        $products = Product::where('category_id', $category->id)
            ->where('status', 1)
            ->paginate(12);

        return view('user.pages.product.categoryWiseProduct', compact('products', 'slug'));
    }



}
