<?php

namespace App\Http\Resources\FAIMS\Procurement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BACResolutionResource extends JsonResource
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
            'bac_resolution_number' =>  $this->bac_resolution_number,
            'body' => $this->body,
            'purchase_request' => $this->purchase_request,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at->format('F d, Y'),
            'updated_at' => $this->updated_at->format('F d, Y'),
        ];
    }
}
