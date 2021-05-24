<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'price',
        'description',
        'status_id',
        'available_count',
        'thumbnail_path',
        'slug'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(ProductStatus::class);
    }

    public function getThumbnailUrlAttribute()
    {
        return Storage::url($this->thumbnail_path);
    }
}
