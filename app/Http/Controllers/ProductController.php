<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductStatus;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *e
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->only(['orderBy', 'order']);

        $params['order'] = $params['order'] ?? null;
        $params['orderBy'] = $params['orderBy'] ?? null;

        ['orderBy' => $orderBy, 'order' => $order] = $params;

        $products = Product::with(['status'])
            ->when(
                $orderBy,
                function ($query) use ($orderBy, $order) {
                    if ($orderBy === 'id') {
                        return $order === 'desc'
                            ? $query->orderByDesc('id')
                            : $query->orderBy('id');
                    }
                    if ($orderBy === 'status') {
                        return $order === 'desc'
                            ? $query->orderByDesc('status_id')
                            : $query->orderBy('status_id');
                    }
                    if ($orderBy === 'title') {
                        return $order === 'desc'
                            ? $query->orderByDesc('title')
                            : $query->orderBy('title');
                    }
                    if ($orderBy === 'price') {
                        return $order === 'desc'
                            ? $query->orderByDesc('price')
                            : $query->orderBy('price');
                    }
                    if ($orderBy === 'available_count') {
                        return $order === 'desc'
                            ? $query->orderByDesc('available_count')
                            : $query->orderBy('available_count');
                    }
                    return $query->orderByDesc('id');
                }
            )
            ->paginate(20);

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
     * @param  \App\Http\Requests\ProductStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $fields = $request->all([
            'title',
            'description',
            'price',
            'status_id',
            'available_count',
        ]);

        if ($request->hasFile('thumbnail')) {
            $fields['thumbnail_path'] = $request
                ->file('thumbnail')
                ->store('public/product-images');
        }

        if ($request->slug) {
            $request->validate([
                'slug' => 'unique:App\Models\Product,slug'
            ]);

            $fields['slug'] = urlencode($request->slug);
        }

        $isCreated = Product::create($fields);

        if (!$isCreated) {
            throw new \Exception('Product was not created');
        }

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
            $request->validate([
                'slug' => 'unique:\App\Models\Product,slug'
            ]);

            $product->update(['slug' => urlencode($request->slug)]);
        }

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('public/product-images');

            if (!$path) {
                throw new Exception('Thumbnail was not stored');
            }

            if ($product->thumbnail_path !== 'public/product-images/default.png') {
                Storage::delete($product->thumbnail_path);
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
    public function destroy(Product $product)
    {
        if ($product->thumbnail_path !== 'public/product-images/default.png') {
            Storage::delete($product->thumbnail_path);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('product.delete_status', 'success');
    }
}
