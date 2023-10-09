<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleItem extends Model
{
    use HasFactory;

    protected $fillable = ['product_id'];

    public function scopeShowActive($query){
        return $query->where('show_at_home', 1)->where('status', 1)->orderBy('id', 'DESC');
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
