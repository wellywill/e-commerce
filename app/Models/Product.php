<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'image_product',
        'gallery_product',
        'price',
        'qty',
        'description',
        'category_id',
    ];

    // Jika gallery_product disimpan dalam bentuk JSON
    protected $casts = [
        'gallery_product' => 'array',
    ];

    // Relasi ke kategori (asumsinya ada model Category)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
