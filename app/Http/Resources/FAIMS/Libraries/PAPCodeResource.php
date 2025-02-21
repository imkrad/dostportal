<?php

namespace App\Http\Resources\FAIMS\Libraries;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PAPCodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'title'=> $this->title,
            'code' =>  $this->code,
            'allocated_budget'=> $this->allocated_budget,
        ];
    }
}
