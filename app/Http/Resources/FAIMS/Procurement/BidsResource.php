<?php

namespace App\Http\Resources\FAIMS\Procurement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UnitTypeResource;

class BidsResource extends JsonResource
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
            'purchase_request' =>  $this->purchase_request,
            'supplier' =>  $this->supplier,
            'status' =>  $this->status,
            'bids_details' => $this->bids_details,
        ];
    }
}
