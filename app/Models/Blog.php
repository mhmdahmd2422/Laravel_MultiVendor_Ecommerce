<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    public function scopeActiveNewest($query)
    {
        return $query->where('status', 1)->orderBy('id', 'DESC');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }
}
