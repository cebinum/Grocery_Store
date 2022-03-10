<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->get();
        $categories = Category::all();
        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $fileNameToStore = $this->uploadPhoto($request);

        $product = new Product();

        $this->storeData($product, $request, $fileNameToStore);

        flash('Product created')->success();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(ProductRepository $repository, $slug)
    {
        $product = $repository->publishedProducts()->where('slug', $slug)->first();

        if (!$product) {
            abort(404);
        }

        $relatedProducts = $repository->relatedProducts($product);

        return view('product-details', compact('product', 'relatedProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        if ($request->hasFile('photo')) {
            $fileNameToStore = $this->uploadPhoto($request);
        } else {
            $fileNameToStore = $product->photo;
        }

        $this->storeData($product, $request, $fileNameToStore);

        flash('Product updated')->success();

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        flash('Item deleted')->success();

        return back();
    }

    public function live(Product $product)
    {
        $product->status = ($product->status == Product::PENDING ? Product::PUBLISHED : Product::PENDING);

        $product->saveOrFail();

        flash('Status updated')->success();

        return back();
    }

    public function uploadPhoto($request)
    {
        $image = $request->file('photo');

        $extention = $image->getClientOriginalExtension();

        $fileNameToStore = time() . '.' . $extention;

        $image->move(public_path() . '/product/', $fileNameToStore);

        return $fileNameToStore;
    }

    public function storeData($product, $request, $fileNameToStore)
    {
        $product->category_id = $request->category;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name . ' ' . $request->product['unit']);
        $product->unit_and_price = $request->product;
        $product->photo = $fileNameToStore;
        $product->saveOrFail();
    }
}
