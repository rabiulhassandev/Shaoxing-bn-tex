<?php

namespace App\Models;

use Database\Factories\FabricFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fabric extends Model
{
    /** @use HasFactory<FabricFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'image',
        'construction',
        'composition',
        'width',
        'weight',
        'finish',
        'colors',
        'moq',
        'lead_time',
        'description',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->image ? asset('storage/'.$this->image) : null);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(FabricCategory::class, 'category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(FabricImage::class)->orderBy('sort_order');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where(function (Builder $query) use ($term) {
            $query->where('name', 'like', "%{$term}%")
                ->orWhere('composition', 'like', "%{$term}%")
                ->orWhere('construction', 'like', "%{$term}%");
        });
    }
}
