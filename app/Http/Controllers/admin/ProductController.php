<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCrossReference;
use App\Models\ProductReview;
use App\Models\ProductSpecification;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Toastr;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('specifications','brand')->latest()->get();
        $categories = Category::where('status', 1)->latest()->get();
        $brand = Brand::where('status', 1)->latest()->get();
        return view('admin.pages.product.index', compact('products', 'categories','brand'));
    }


    public function store(Request $request)
    {

        try {
            $request->validate([
                'category_id' => 'required',
                'name' => 'required',
                'price' => 'required',
                'stock' => 'required',
                'image' => 'required',
                'spec_title' => 'required|array',
                'spec_value' => 'required|array',
                'part_number' => 'required|array',
                'company_name' => 'required|array',
            ]);
            $imagePaths = [];
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $imageFile) {
                    $imageName = time() . '_' . uniqid() . '.' . $imageFile->extension();
                    $imageFile->move(public_path('images/product'), $imageName);
                    $imagePaths[] = $imageName;
                }
            }
            $product = new Product();
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id ?? null; // Optional brand_id

            //auto generate ean_no random number

            $product->ean_no = $request->ean_no ?? 'DYS-' . rand(1000000000, 9999999999); // Optional EAN number, auto-generated if not provided


            $product->model_no = $request->model_no ?? null; // Optional model number
            $product->type = $request->type ?? null; // Optional type
            $product->year = $request->year ?? null; // Optional year
            $product->name = $request->name;
            $product->price = $request->price;
            $product->sale_price =$request->sale_price;
            $product->stock = $request->stock;
            $product->available_stock =$request->stock;
            $product->details = $request->details;
            $product->image = json_encode($imagePaths);
            $product->save();

            // Save product specifications
            foreach ($request->spec_title as $index => $title) {
                if (!empty($title) && isset($request->spec_value[$index])) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'title' => $title,
                        'value' => $request->spec_value[$index]
                    ]);
                }
            }

            // Save product cross references
            foreach ($request->part_number as $index => $partNumber) {
                if (!empty($partNumber) && isset($request->company_name[$index])) {
                    ProductCrossReference::create([
                        'product_id' => $product->id,
                        'part_number' => $partNumber,
                        'company_name' => $request->company_name[$index]
                    ]);
                }
            }


            Toastr::success('Product Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }



//    public function update(Request $request, $id)
//    {
//        try {
//            $request->validate([
//                'category_id' => 'required',
//                'name' => 'required',
//                'price' => 'required',
//                'stock' => 'required',
//                'image' => 'sometimes|array',
//                'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            ]);
//            $product = Product::findOrFail($id);
//            $imagePaths = json_decode($product->image, true) ?? [];
//
//            // Update images
//            if ($request->hasFile('image')) {
//                foreach ($request->file('image') as $imageFile) {
//                    $imageName = time() . '_' . uniqid() . '.' . $imageFile->extension();
//                    $imageFile->move(public_path('images/product'), $imageName);
//                    $imagePaths[] = $imageName;
//                }
//            }
//
//            // Remove deleted images
//            if ($request->has('deleted_images')) {
//                $deletedImages = json_decode($request->deleted_images, true);
//                $imagePaths = array_diff($imagePaths, $deletedImages);
//                foreach ($deletedImages as $deletedImage) {
//                    $imagePath = public_path('images/product/' . $deletedImage);
//                    if (!empty($deletedImage) && file_exists($imagePath) && is_file($imagePath)) {
//                        unlink($imagePath);
//                    }
//                }
//            }
//
//            //dd($request->all());
//            $product->update([
//                'category_id' => $request->category_id,
//                'name' => $request->name,
//                'price' => $request->price,
//                'sale_price' => $request->sale_price,
//                'stock' => $request->stock,
//                'available_stock' => $request->stock,
//                'details' => $request->details,
//                'status' => $request->status,
//                'image' => json_encode(array_values($imagePaths)),
//            ]);
//
//            Toastr::success('Product updated successfully', 'Success');
//            return redirect()->back();
//        } catch (\Exception $e) {
//            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
//        }
//    }


    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $images = json_decode($product->image, true);
            if ($images) {
                foreach ($images as $image) {
                    $imagePath = public_path('images/product/' . $image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
            $product->delete();
            Toastr::success('Product deleted successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }



}
