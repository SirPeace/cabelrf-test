<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\ProductStatus;
use Exception;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(20);

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_statuses = ProductStatus::all()->toBase();

        return view('products.create', compact('product_statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product_statuses = ProductStatus::all()->toBase();

        return view('products.edit', compact('product', 'product_statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductUpdateRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request->all([
            'title',
            'price',
            'description',
            'status_id',
            'available_count'
        ]));

        if ($product->status->name === 'out-of-stock') {
            $product->update(['available_count' => 0]);
        }

        if ($request->slug !== $product->slug) {
            $validator = Validator::make(
                ['slug' => $request->slug],
                ['slug' => 'unique:\App\Models\Product,slug']
            );

            $validator->validate($product->slug);

            $product->update(['slug' => urlencode($request->slug)]);
        }

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('public/product-images');

            if (!$path) {
                throw new Exception('Thumbnail was not stored');
            }

            $product->update(['thumbnail_path' => $path]);e
        }

        return back()->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        dd('Delete', $product);
    }

    /**
     * Upload product thumbnail (via AJAX)
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadThumbnail(Request $request)
    {
        dd($request->file('file'));
    }
}
