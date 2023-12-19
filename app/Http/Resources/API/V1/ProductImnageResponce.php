<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImnageResponce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "ID"            =>      $this->id,
            "Product ID"    =>      $this->product_id,
            "image"         =>      asset(env('PRODUCT_SHOW_PATH_IMAGES') . $this->image)
        ];
    }
}
