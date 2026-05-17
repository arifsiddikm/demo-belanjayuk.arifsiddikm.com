<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model {
    protected $fillable = ['code','description','type','value','min_purchase','max_discount','usage_limit','used_count','is_active','starts_at','expires_at'];
    protected $casts = ['is_active'=>'boolean','starts_at'=>'date','expires_at'=>'date'];
    public function isValid(): bool {
        if (!$this->is_active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        return true;
    }
    public function calculateDiscount($subtotal): float {
        if ($subtotal < $this->min_purchase) return 0;
        if ($this->type === 'percentage') {
            $d = ($subtotal * $this->value) / 100;
            return $this->max_discount ? min($d, $this->max_discount) : $d;
        }
        return $this->value;
    }
}
