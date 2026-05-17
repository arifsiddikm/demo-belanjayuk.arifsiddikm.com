<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Address extends Model {
    protected $fillable = ['user_id','label','recipient_name','phone','address','province_id','province_name','city_id','city_name','district_id','district_name','postal_code','is_default'];
    protected $casts = ['is_default'=>'boolean'];
    public function user() { return $this->belongsTo(User::class); }
}
