<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\V1\ProductImnageResponce;
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
            "primary_image"     =>  asset(env('PRODUCT_SHOW_PATH_IMAGES') . $this->primary_image),
            "Brand"             =>  $this->brand->name,
            "Category"          =>  $this->category->name,
            "price"             =>  $this->price,
            "quantity"          =>  $this->quantity,
            "description"       =>  $this->description,
            "delivery_amount"   =>  $this->delivery_amount,
            "created_at"        =>  $this->created_at,
            "Images"            =>  ProductImnageResponce::collection($this->whenLoaded('images')),
        ];
    }
}
