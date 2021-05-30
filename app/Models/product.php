<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $fillable = [
        'category_id',
        'brand_id',
        'title',
        'description',
        'slug',
        'quantity',
        'price',
        'status',
        'offer_price',
        'admin_id',
        
    ];
    
}
