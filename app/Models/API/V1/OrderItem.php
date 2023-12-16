<?php

namespace App\Models\API\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "order_items";

    /**
     * @var string[]
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
        'subtotal',
    ];


}
