<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {
    protected $table = 'order_items';
    protected $fillable = ['order_id','product_id','product_variant_id','product_name','product_thumbnail','variant_info','quantity','price','subtotal'];
    public function order() { return $this->belongsTo(Order::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
