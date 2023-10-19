<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function scopeActiveApproved($query){
        return $query->where('is_approved', 1)->where('status', 1);
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function gallery(){
        return $this->hasMany(ProductImageGallery::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function variants(){
        return $this->hasMany(ProductVariant::class);
    }

}
