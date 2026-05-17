<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model {
    protected $fillable = ['name','slug','icon','image','description','sort_order','is_active'];
    protected $casts = ['is_active'=>'boolean'];
    public function products() { return $this->hasMany(Product::class); }
    public function activeProducts() { return $this->hasMany(Product::class)->where('is_active',true); }
    protected static function boot() {
        parent::boot();
        static::creating(fn($c) => $c->slug = $c->slug ?: Str::slug($c->name));
    }
}
