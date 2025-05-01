<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_name',
    ];

    public function getImage()
    {
        return asset("/storage/product_images/product_{$this->product_id}/".$this->image_name);
    }
}
