<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleItem extends Model
{
    use HasFactory;

    protected $fillable = ['product_id'];

    public function scopeShowActive($query){
        return $query->where('status', 1)->orderBy('id', 'ASC');
    }

    public function product(){
        $instance = $this->belongsTo(Product::class);
        $instance->getQuery()
            ->where(['status' => 1, 'is_approved' => 1]);
        return $instance;
    }
}
