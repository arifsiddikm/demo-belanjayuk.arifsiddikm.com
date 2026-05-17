<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model {
    protected $table    = 'product_reviews';
    protected $fillable = ['product_id','user_id','order_id','rating','comment','image','images','is_approved'];
    protected $casts    = [
        'is_approved' => 'boolean',
        'images'      => 'array',  // JSON array of multiple images
    ];

    public function product() { return $this->belongsTo(Product::class); }
    public function user()    { return $this->belongsTo(User::class); }

    /** Semua gambar (gabung image lama + images array baru) */
    public function getAllImagesAttribute(): array {
        $all = [];
        if ($this->image) $all[] = $this->image;
        if ($this->images) $all = array_merge($all, $this->images);
        return array_unique(array_filter($all));
    }

    /** URL gambar pertama */
    public function getFirstImageUrlAttribute(): ?string {
        $imgs = $this->all_images;
        if (empty($imgs)) return null;
        $img = $imgs[0];
        return str_starts_with($img, 'http') ? $img : asset('storage/' . $img);
    }
}
