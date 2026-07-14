<?php

namespace App\Models;

use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /** @use HasFactory<PageFactory> */
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'intro',
        'body',
        'banner_image',
        'meta_title',
        'meta_description',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function bannerUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->banner_image ? asset('storage/'.$this->banner_image) : null);
    }
}
