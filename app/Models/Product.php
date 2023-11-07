<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $products = 'products';
    protected $fillable = [
        'name',
        'price',
        'description',
        'shortdescription',
        'coverimage',
        'category',
    ];

    }

