<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Image;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('is_active', 1)
            ->with('category')
            ->latest('id')
            ->select('id', 'category_id', 'name', 'slug', 'product_price', 'product_stock', 'alert_quantity', 'product_image', 'product_rating','updated_at')
            ->paginate(20);

        //return $products;

            return view('backend.pages.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select(['id','title'])->get();
        return view('backend.pages.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'product_code' => $request->product_code,
            'product_price' => $request->product_price,
            'product_stock' => $request->product_stock,
            'alert_quantity' => $request->alert_quantity,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'additional_info' => $request->additional_info,
        ]);

        $this->image_upload($request, $product->id);
        Toastr::success('Data Stored Successfully!');
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $product = Product::whereSlug($slug)->first();
        // return $product;
        $categories = Category::select(['id','title'])->get();
        return view('backend.pages.product.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $slug)
    {
        $product = Product::whereSlug($slug)->first();
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'product_code' => $request->product_code,
            'product_price' => $request->product_price,
            'product_stock' => $request->product_stock,
            'alert_quantity' => $request->alert_quantity,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'additional_info' => $request->additional_info,
        ]);

        $this->image_upload($request, $product->id);
        Toastr::success('Data Updated Successfully!');
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $product = Product::whereSlug($slug)->first();
        if($product->product_image){
            $photo_location = 'uploads/product_photos/'.$product->product_image;
            unlink($photo_location);
        }

        $product->delete();

        Toastr::success('Data Deleted Successfully!');
        return redirect()->route('products.index');
    }

    public function image_upload($request, $product_id)
    {
        $product = Product::findorFail($product_id);
        if ($request->hasFile('product_image')) {
            if ($product->product_image != 'default_product.jpg') {
                //delete old photo
                $photo_location = 'public/uploads/product_photos/';
                $old_photo_location = $photo_location . $product->product_image;
                unlink(base_path($old_photo_location));
            }
            $photo_location = 'public/uploads/product_photos/';
            $uploaded_photo = $request->file('product_image');
            $new_photo_name = $product->id . '.' . $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = $photo_location . $new_photo_name;
            Image::make($uploaded_photo)->resize(600, 600)->save(base_path($new_photo_location), 40);
            $check = $product->update([
                'product_image' => $new_photo_name,
            ]);
        }
    }
}
