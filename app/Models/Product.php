<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model {
    protected $fillable = ['category_id','name','slug','sku','short_description','description','price','sale_price','stock','weight','length','width','height','thumbnail','is_active','is_featured','is_promo','is_new','views','sold_count'];
    protected $casts = ['is_active'=>'boolean','is_featured'=>'boolean','is_promo'=>'boolean','is_new'=>'boolean'];
    public function category() { return $this->belongsTo(Category::class); }
    public function images() { return $this->hasMany(ProductImage::class)->orderBy('sort_order'); }
    public function variants() { return $this->hasMany(ProductVariant::class); }
    public function reviews() { return $this->hasMany(ProductReview::class)->where('is_approved',true); }
    public function wishlists() { return $this->hasMany(Wishlist::class); }
    public function getEffectivePriceAttribute(): float { return $this->sale_price ?? $this->price; }
    public function getDiscountPercentAttribute(): int {
        if ($this->sale_price && $this->price > 0) return (int)round((($this->price - $this->sale_price)/$this->price)*100);
        return 0;
    }
    public function getAverageRatingAttribute(): float { return (float)($this->reviews()->avg('rating') ?? 0); }
    public function getThumbnailUrlAttribute(): string {
        if (!$this->thumbnail) return asset('images/placeholder.jpg');
        if (Str::startsWith($this->thumbnail,'http')) return $this->thumbnail;
        return asset('storage/'.$this->thumbnail);
    }
    protected static function boot() {
        parent::boot();
        static::creating(fn($p) => $p->slug = $p->slug ?: Str::slug($p->name).'-'.Str::random(5));
    }
    public function scopeActive($q) { return $q->where('is_active',true); }
    public function scopeFeatured($q) { return $q->where('is_featured',true); }
    public function scopePromo($q) { return $q->where('is_promo',true); }
}
