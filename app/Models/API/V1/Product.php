<?php

namespace App\Models\API\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "products";


    /**
     * @var string[]
     */
    protected $fillable = [
        'brand_id',
        'category_id',
        'primary_image',
        'price',
        'quantity',
        'description',
        'delivery_amount'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
