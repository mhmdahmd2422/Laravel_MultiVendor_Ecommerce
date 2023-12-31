<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    public function scopeActiveFeatured($query){
        return $query->where('is_featured', 1)->where('status', 1);
    }

    public function scopeActive($query){
        return $query->where('status', 1);
    }
}
