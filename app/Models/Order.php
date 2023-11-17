<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function scopeWhereStatus($query, $status)
    {
        return $query->where('order_status', $status);
    }

    public function scopeWhereStatusNot($query, $status)
    {
        return $query->where('order_status', '!=', $status);
    }

    public function scopeOrWhereStatus($query, $status)
    {
        return $query->OrWhere('order_status', $status);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->hasMany(OrderProduct::class);
    }

    public function transaction(){
        return $this->hasOne(Transaction::class);
    }
}
