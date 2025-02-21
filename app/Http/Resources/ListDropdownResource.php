<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListDropdownResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' =>  $this->name,
            'classification' =>  $this->classification,
            'type' =>  $this->type,
            'color' =>  $this->color,
            'others' =>  $this->others,
            'is_active' =>  $this->is_active,
        ];
    }
}
