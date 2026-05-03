<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id', 'sku',
        'color_id', 'material_id', 'fit_id',
        'sleeve_id', 'collar_id', 'pattern_id', 'gender_id',
        'unit_id', 'price',
    ];

    public function product(): BelongsTo  { return $this->belongsTo(Product::class); }
    public function color(): BelongsTo   { return $this->belongsTo(Color::class); }
    public function material(): BelongsTo{ return $this->belongsTo(Material::class); }
    public function fit(): BelongsTo     { return $this->belongsTo(Fit::class); }
    public function sleeve(): BelongsTo  { return $this->belongsTo(Sleeve::class); }
    public function collar(): BelongsTo  { return $this->belongsTo(Collar::class); }
    public function pattern(): BelongsTo { return $this->belongsTo(Pattern::class); }
    public function gender(): BelongsTo  { return $this->belongsTo(Gender::class); }
    public function unit(): BelongsTo    { return $this->belongsTo(Unit::class); }

    public function images(): HasMany
    {
        return $this->hasMany(ProductVariantImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function sizeStocks(): HasMany
    {
        return $this->hasMany(VariantSizeStock::class)->with('size')->orderBy('id');
    }

    /** Total stok dari semua ukuran */
    public function getTotalStockAttribute(): int
    {
        return $this->sizeStocks->sum('stock');
    }
}
