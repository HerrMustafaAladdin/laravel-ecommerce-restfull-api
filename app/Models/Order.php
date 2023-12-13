<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "orders";

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'status',
        'total_amount',
        'paying_amount',
        'delivery_amount',
        'payment_status',
        'description',
    ];
}
