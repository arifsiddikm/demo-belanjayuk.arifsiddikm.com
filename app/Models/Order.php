<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = ['order_number','user_id','address_id','recipient_name','recipient_phone','recipient_address','province_name','city_name','district_name','postal_code','courier','courier_service','courier_service_name','shipping_cost','estimated_days','subtotal','discount','coupon_code','total','payment_method','payment_status','payment_proof','midtrans_transaction_id','midtrans_snap_token','midtrans_response','status','tracking_number','notes','cancel_reason','paid_at','shipped_at','delivered_at','completed_at','cancelled_at'];
    protected $casts = ['paid_at'=>'datetime','shipped_at'=>'datetime','delivered_at'=>'datetime','completed_at'=>'datetime','cancelled_at'=>'datetime'];
    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class); }
    public function paymentConfirmation() { return $this->hasOne(PaymentConfirmation::class); }
    public function getStatusLabelAttribute(): string {
        return match($this->status) {
            'menunggu_bayar'=>'Menunggu Bayar','diproses'=>'Diproses','dikirim'=>'Dikirim',
            'diterima'=>'Diterima','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan',default=>ucfirst($this->status),
        };
    }
    public function getStatusColorAttribute(): string {
        return match($this->status) {
            'menunggu_bayar'=>'yellow','diproses'=>'blue','dikirim'=>'purple',
            'diterima'=>'indigo','selesai'=>'green','dibatalkan'=>'red',default=>'gray',
        };
    }
    public static function generateOrderNumber(): string {
        $prefix = config('app.order_prefix','INV');
        return $prefix.now()->format('Ymd').str_pad(static::whereDate('created_at',today())->count()+1,4,'0',STR_PAD_LEFT);
    }
}
