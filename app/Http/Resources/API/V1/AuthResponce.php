<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResponce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'           =>     $this->name,
            'email'          =>     $this->email,
            'address'        =>     $this->address,
            'cellphone'      =>     $this->cellphone,
            'province_id'    =>     $this->province_id,
            'city_id'        =>     $this->city_id,
        ];
    }
}
