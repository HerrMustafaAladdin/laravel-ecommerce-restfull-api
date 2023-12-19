<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResponce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "Brand"             =>  $this->brand_id,
            "Category"          =>  $this->category_id,
            "price"             =>  $this->price,
            "quantity"          =>  $this->quantity,
            "description"       =>  $this->description,
            "delivery_amount"   =>  $this->delivery_amount,
            "created_at"        =>  $this->created_at,
        ];
    }
}
