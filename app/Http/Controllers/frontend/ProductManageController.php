<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
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
            ->orWhere('id', $slug)
            ->firstOrFail();

        $query = Product::where('category_id', $category->id)
            ->with(['category', 'brand', 'specifications'])
            ->where('status', 1);

        // Voltage filter using ProductSpecification
        if ($request->has('voltage') && is_array($request->voltage)) {
            $voltages = $request->voltage;

            $query->whereHas('specifications', function ($q) use ($voltages) {
                $q->where('title', 'Volt')
                    ->whereIn('value', $voltages);
            });
        }

        $products = $query->paginate(20);

        return view('user.pages.product.categoryWiseProduct', compact('products', 'slug'));
    }



    public function searchProduct(Request $request)
    {
        // Load filters
        $categories = Category::all();
        $brands = Brand::all();

        // Start building query
        $products = Product::query()->with(['category', 'brand', 'specifications']);

        // Filter: category
        if ($request->filled('category_id')) {
            $products->where('category_id', $request->category_id);
        }

        // Filter: brand
        if ($request->filled('brand_id')) {
            $products->where('brand_id', $request->brand_id);
        }

        // Filter: model number
        if ($request->filled('model_no')) {
            $products->where('model_no', 'like', '%' . $request->model_no . '%');
        }

        // Filter: Volt from specifications
        if ($request->filled('volt')) {
            $products->whereHas('specifications', function ($query) use ($request) {
                $query->where('title', 'Volt')
                    ->where('value', $request->volt);
            });
        }

        // Filter: KW from specifications
        if ($request->filled('kw')) {
            $products->whereHas('specifications', function ($query) use ($request) {
                $query->where('title', 'KW')
                    ->where('value', $request->kw);
            });
        }

        // Only show products if any filter is used
        $filtered = $request->filled('category_id') || $request->filled('brand_id') || $request->filled('model_no') || $request->filled('volt') || $request->filled('kw');
        $products = $filtered ? $products->get() : collect();

        return view('user.pages.product.productSearch', compact('products', 'categories', 'brands'));
    }



}
