<?php

namespace App\Models;

use Database\Factories\InquiryItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InquiryItem extends Model
{
    /** @use HasFactory<InquiryItemFactory> */
    use HasFactory;

    protected $fillable = [
        'inquiry_id',
        'fabric_id',
        'fabric_name',
        'quantity',
        'target_price',
        'note',
    ];

    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function fabric(): BelongsTo
    {
        return $this->belongsTo(Fabric::class);
    }
}
