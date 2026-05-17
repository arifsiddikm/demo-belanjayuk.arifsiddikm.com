<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
    protected $fillable = ['user_id','product_id','product_variant_id','quantity'];
    public function user() { return $this->belongsTo(User::class); }
    public function product() { return $this->belongsTo(Product::class); }
    public function variant() { return $this->belongsTo(ProductVariant::class,'product_variant_id'); }
    public function getSubtotalAttribute(): float {
        $price = $this->product->effective_price ?? 0;
        if ($this->variant) $price += $this->variant->price_adjustment;
        return $price * $this->quantity;
    }
}
