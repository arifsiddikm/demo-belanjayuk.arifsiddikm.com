<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductImage extends Model {
    protected $table = 'product_images';
    protected $fillable = ['product_id','image','sort_order'];
    public function product() { return $this->belongsTo(Product::class); }
    public function getImageUrlAttribute(): string {
        if (Str::startsWith($this->image,'http')) return $this->image;
        return asset('storage/'.$this->image);
    }
}
