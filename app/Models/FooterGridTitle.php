<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterGridTitle extends Model
{
    use HasFactory;

    protected $fillable = ['grid_two_title', 'grid_three_title'];
}
