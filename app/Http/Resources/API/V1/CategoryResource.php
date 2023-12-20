<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ParentID'      =>  $this->parent_id,
            'Name'          =>  $this->name,
            'Description'   =>  $this->description,
            'Creation time' =>  $this->created_at,
            'Editing time'  =>  $this->updated_at,
            'Children'      =>  CategoryResource::collection($this->whenLoaded('children')),
            'Parent'        =>  new CategoryResource($this->whenLoaded('parent')),
            'Products'      =>  ProductResponce::collection($this->whenLoaded('products')->load('images'))
        ];
    }
}
