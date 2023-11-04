<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    public function scopeStatusActiveCoupons($query){
        return $query->where('status', 1);
    }

    public function scopeDateActiveCoupons($query){
        return $query
            ->where('end_date', '>=' , date('Y-m-d'))
            ->where('start_date', '<=' , date('Y-m-d'));
    }

    public function scopeQuantityActiveCoupons($query){
        return $query->where('quantity' , '>', 'total_used');
    }
}
