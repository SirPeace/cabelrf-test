<?php

namespace App\Http\Controllers;

use App\Exceptions\UnsupportedFileTypeException;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductStatus;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\ProductThumbnailManager;
use App\Repositories\ProductRepository;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductRepository $productRepository)
    {
        $products = $productRepository->indexProducts(20);

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('manage-products');

        $product_statuses = ProductStatus::all()->toBase();

        return view('products.create', compact('product_statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $this->authorize('manage-products');

        $fields = $request->only([
            'title',
            'description',
            'price',
            'status_id',
            'available_count',
        ]);

        // Upload thumbnail
        if ($request->hasFile('thumbnail')) {
            $thumbnailManager = new ProductThumbnailManager();

            try {
                $path = $thumbnailManager->store($request->file('thumbnail'));
            } catch (UnsupportedFileTypeException $e) {
                return back()->withInput()->withErrors([
                    'thumbnail' => $e->getMessage()
                ]);
            }

            $fields['thumbnail_path'] = $path;
        }

        // Create slug
        if ($request->filled('slug')) {
            $request->validate([
                'slug' => 'unique:App\Models\Product,slug'
            ]);

            $fields['slug'] = urlencode($request->slug);
        }

        Product::create($fields);

        return redirect()
            ->route('products.index')
            ->with('product.create_status', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('manage-products');

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
        $this->authorize('manage-products');

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
            $request->validate([
                'slug' => 'unique:\App\Models\Product,slug'
            ]);

            $product->update(['slug' => urlencode($request->slug)]);
        }

        if ($request->hasFile('thumbnail')) {
            $thumbnailManager = new ProductThumbnailManager();

            try {
                $path = $thumbnailManager->update($request->file('thumbnail'), $product->thumbnail_path);
            } catch (UnsupportedFileTypeException $e) {
                return back()->withInput()->withErrors([
                    'thumbnail' => $e->getMessage()
                ]);
            }

            $product->update(['thumbnail_path' => $path]);
        }

        return back()->with('product.update_status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductThumbnailManager $thumbnailManager)
    {
        $this->authorize('manage-products');

        $thumbnailManager->delete($product->thumbnail_path);

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('product.delete_status', 'success');
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyMultiple(Request $request, ProductThumbnailManager $thumbnailManager)
    {
        $this->authorize('manage-products');

        $fields = Arr::where(
            $request->all(),
            fn ($value, $key) => str_starts_with($key, 'product-id') && $value === "on"
        );

        $productIds = array_map(
            fn ($field) => explode(':', $field, 2)[1],
            array_keys($fields)
        );

        $products = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            $thumbnailManager->delete($product->thumbnail_path);

            $product->delete();
        }

        return redirect()
            ->route('products.index')
            ->with('product.multiple_delete_status', 'success');
    }
}
