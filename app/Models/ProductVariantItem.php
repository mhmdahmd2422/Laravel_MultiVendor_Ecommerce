<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantItem extends Model
{
    use HasFactory;

    public function scopeActiveVariantItems($query){
        return $query->where('status', 1);
    }

    public function variant(){
        return $this->belongsTo(ProductVariant::class);
    }
}
