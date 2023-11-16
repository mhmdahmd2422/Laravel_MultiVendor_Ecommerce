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

    public function scopeInactive($query){
        return $query->orWhere('status', 0);
    }

    public function scopeInactiveOrUnapproved($query){
        return $query->where('is_approved', 0)->orWhere('status', 0);
    }

    public function scopePriceRange($query, $request){
        return $query->when($request->has('price_slider') && $request->price_slider != null, function ($query) use ($request) {
            $range = explode(';', $request->price_slider);
            $from = $range[0];
            $to = $range[1];

            return $query->where('price', '>=', $from)->where('price', '<=', $to);
        });
    }

    public function scopeSelectedBrand($query, $request){
        return $query->when($request->has('brand'), function ($query) use ($request) {
            $brand = Brand::where('slug', $request->brand)->firstOrFail();
            return $query->where('brand_id', $brand->id);
        });
    }

    public function scopeProductSearch($query, $request){
        return $query->when($request->has('search'), function ($query) use ($request) {
            return $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('long_description', 'like', '%'.$request->search.'%')
                ->orWhereHas('category', function ($query) use ($request){
                    $query->where('name', 'like', '%'.$request->search.'%')
                        ->orWhere('long_description', 'like', '%'.$request->search.'%');
                });
        });
    }

    public function scopeListType($query, $list_type){
        return $query->where('list_type', $list_type);
    }

    public function scopeVendorIs($query, $vendor)
    {
        $query->where('vendor_id', $vendor);
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

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}
