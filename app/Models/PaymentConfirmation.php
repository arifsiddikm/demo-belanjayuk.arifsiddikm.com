<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PaymentConfirmation extends Model {
    protected $table = 'payment_confirmations';
    protected $fillable = ['order_id','user_id','bank_name','account_name','account_number','amount','transfer_proof','status','admin_notes'];
    public function order() { return $this->belongsTo(Order::class); }
    public function user() { return $this->belongsTo(User::class); }
}
