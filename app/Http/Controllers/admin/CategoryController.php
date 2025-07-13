<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Toastr;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.pages.category.index', compact('categories'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            $file = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/category'), $file);
            $category = new Category();
            $category->name = $request->name;
            $category->slug = Str::slug($request->name); // Changed here
            $category->image = $file;
            $category->save();
            Toastr::success('Category Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        try {
            $request->validate([
                'name' => 'required',
            ]);
            $category = Category::find($id);
            $category->name = $request->name;
            $category->status = $request->status;
            if ($request->image) {
                $file = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/category'), $file);
                $category->image = $file;
            }
            $category->save();
            Toastr::success('Category Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            $category->delete();
            Toastr::success('Category Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function getSubCategories($id)
    {
         $subCategories = SubCategory::where('category_id', $id)->get();
         return response()->json($subCategories);
    }
}
