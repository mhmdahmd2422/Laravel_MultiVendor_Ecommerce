<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    public function scopeActive($query){
        return $query->where('status', 1);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function variantItems(){
        return $this->hasMany(ProductVariantItem::class, 'variant_id');
    }

    public function ActiveVariantItems(){
        return $this->variantItems()->ActiveVariantItems();
    }
}
