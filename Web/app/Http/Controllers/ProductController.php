<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::with('user')->get(); // Fetch all products with their associated user
        return view('marketplace.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('marketplace.create');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
   
     public function store(Request $request)
     {
         $request->validate([
             'name' => 'required|string|max:255',
             'description' => 'nullable|string',
             'price' => 'required|numeric', 
     
             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);
     
         $product = new Product();
         $product->name = $request->input('name');
         $product->description = $request->input('description');
         $product->price  = $request->input('price');
         $product->user_id  = Auth::id();
         if($request->hasFile('image'))
         {
             $file = $request->file('image');
             $path = public_path().'/uploads/gallery/gallery_file/';
             $filename = date('ymdhis').$file->getClientOriginalName();
             $file->move($path, $filename);
             
             
            
             $product->image= '/uploads/gallery/gallery_file/'.$filename;
            
         }
     
         $product->save();
     
         return redirect()->route('marketplace.index')->with('success', 'Product created successfully!');
     }

    /**
     * Display the specified product.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        return view('marketplace.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('marketplace.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image',
    ]);

    $product->name = $request->input('name');
    $product->description = $request->input('description');
    $product->price = $request->input('price');

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        
        // Define the path where you want to save the image
        $path = storage_path('app/public/products');
        // Store the image in the specified path and get the filename
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs($path, $filename, 'public'); // Use the 'public' disk

        // Optional: Remove the old file if it exists
        $oldFile = $product->image; // Assuming this is the path in the database
        if ($oldFile) {
            $oldPath = storage_path('app/public/' . $oldFile);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }
        
        // Update the image path in the database
        $product->image = $path . '/' . $filename;
    }

    $product->save();

    return redirect()->route('marketplace.index')->with('success', 'Product updated successfully!');
}


    /**
     * Remove the specified product from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        // Delete image if it exists
        if ($product->image && Storage::exists('public/products/' . $product->image)) {
            Storage::delete('public/products/' . $product->image);
        }

        $product->delete();

        return redirect()->route('marketplace.index')->with('success', 'Product deleted successfully!');
    }
}
