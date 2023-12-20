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

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
