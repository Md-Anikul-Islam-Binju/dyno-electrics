<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;use App\Models\Size;
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
        $products = Product::latest()->get();
        //$products = Product::orderBy('serial_no')->get();
        $categories = Category::where('status', 1)->latest()->get();

        return view('admin.pages.product.index', compact('products', 'categories'));
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
            $product->name = $request->name;
            $product->price = $request->price;
            $product->sale_price =$request->sale_price;
            $product->stock = $request->stock;
            $product->available_stock =$request->stock;
            $product->details = $request->details;
            $product->image = json_encode($imagePaths);
            $product->save();
            Toastr::success('Product Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }



    public function update(Request $request, $id)
    {

        try {
            $request->validate([
                'category_id' => 'required',
                'name' => 'required',
                'price' => 'required',
                'stock' => 'required',
                'image' => 'sometimes|array',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $product = Product::findOrFail($id);
            $imagePaths = json_decode($product->image, true) ?? [];

            // Update images
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $imageFile) {
                    $imageName = time() . '_' . uniqid() . '.' . $imageFile->extension();
                    $imageFile->move(public_path('images/product'), $imageName);
                    $imagePaths[] = $imageName;
                }
            }

            // Remove deleted images
            if ($request->has('deleted_images')) {
                $deletedImages = json_decode($request->deleted_images, true);
                $imagePaths = array_diff($imagePaths, $deletedImages);
                foreach ($deletedImages as $deletedImage) {
                    $imagePath = public_path('images/product/' . $deletedImage);
                    if (!empty($deletedImage) && file_exists($imagePath) && is_file($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }

            //dd($request->all());
            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'stock' => $request->stock,
                'available_stock' => $request->stock,
                'details' => $request->details,
                'status' => $request->status,
                'image' => json_encode(array_values($imagePaths)),
            ]);
            Toastr::success('Product updated successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


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
