<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantSizeStock extends Model
{
    protected $fillable = ['product_variant_id', 'size_id', 'stock'];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }
}
