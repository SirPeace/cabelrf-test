<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Get users for index page
     * (searchable, sortable, paginated)
     *
     * @param int $paginate
     * @return \Illuminate\Pagination\Paginator
     */
    public function indexUsers(int $paginate)
    {
        $orderBy = request('orderBy') ?? null;
        $order = request('order') ?? null;
        $search = request('s') ?? null;

        return User::with(['role'])
            ->when(
                $orderBy,
                function ($query) use ($orderBy, $order) {
                    if ($orderBy === 'id') {
                        return $order === 'desc'
                            ? $query->orderByDesc('id')
                            : $query->orderBy('id');
                    }
                    if ($orderBy === 'name') {
                        return $order === 'desc'
                            ? $query->orderByDesc('name')
                            : $query->orderBy('name');
                    }
                    if ($orderBy === 'age') {
                        return $order === 'desc'
                            ? $query->orderByDesc('age')
                            : $query->orderBy('age');
                    }
                    if ($orderBy === 'sex') {
                        return $order === 'desc'
                            ? $query->orderByDesc('sex')
                            : $query->orderBy('sex');
                    }
                    if ($orderBy === 'role') {
                        return $order === 'desc'
                            ? $query->orderByDesc('role_id')
                            : $query->orderBy('role_id');
                    }
                    return $query->latest();
                }
            )
            ->when(!$orderBy, fn ($query) => $query->latest())
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%$search%");
            })
            ->paginate($paginate);
    }
}
