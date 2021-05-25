<?php

namespace App;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository
{
    /**
     * Get products paginator which is sortable via query string
     *
     * @param int $paginate
     * @return \Illuminate\Pagination\Paginator
     */
    public function getPaginatedSortableProducts(int $paginate)
    {
        $orderBy = request('orderBy') ?? null;
        $order = request('order') ?? null;
        $search = request('s') ?? null;

        return Product::with(['status'])
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
                    return $query->latest();
                }
            )
            ->when(!$orderBy, fn ($query) => $query->latest())
            ->when($search, function ($query) use ($search) {
                return $query->where('title', 'like', "%$search%");
            })
            ->paginate($paginate);
    }
}
