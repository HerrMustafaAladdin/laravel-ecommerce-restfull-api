<?php

namespace App\Models\API\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = "categories";


    /**
     * @var string[]
     */
    protected $fillable = [
        'parent_id',
        'name',
        'description'
    ];

}
