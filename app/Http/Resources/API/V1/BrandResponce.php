<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResponce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Name'  =>  $this->name,
            'Display name'  =>  $this->display_name,
            'Created Data'  =>  $this->created_at,
            'Updated Data'  =>  $this->updated_at,
            'Deleted Data'  =>  is_null($this->deleted_at) ? '-' : 'Deleted'
        ];
    }
}
