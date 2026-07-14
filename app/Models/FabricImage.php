<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FabricImage extends Model
{
    protected $fillable = [
        'fabric_id',
        'path',
        'sort_order',
    ];

    protected function url(): Attribute
    {
        return Attribute::get(fn (): string => asset('storage/'.$this->path));
    }

    public function fabric(): BelongsTo
    {
        return $this->belongsTo(Fabric::class);
    }
}
