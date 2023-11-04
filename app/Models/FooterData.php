<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterData extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'phone',
        'address',
        'email',
        'copyrights',
    ];
}
