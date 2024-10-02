<?php

namespace App\Http\Resources\FAIMS\Procurement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UnitTypeResource;

class PurchaseRequesItemDetailResource extends JsonResource
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
            'purchase_request' =>  $this->purchase_request ? new PurchaseRequestResource($this->purchase_request): null,
            'purchase_request_unit' =>  $this->purchase_request_unit,
            'item_unit_type' =>  $this->item_unit_type ? new UnitTypeResource($this->item_unit_type): null,
            'item_description' =>  $this->item_description,
            'item_quantity' =>  $this->item_quantity,
            'item_price' =>  $this->pap_code,
            'status' =>  $this->status,
        ];
    }
}
