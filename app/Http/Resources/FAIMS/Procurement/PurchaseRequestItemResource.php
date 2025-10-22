<?php

namespace App\Http\Resources\FAIMS\Procurement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UnitTypeResource;

class PurchaseRequestItemResource extends JsonResource
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
            'purchase_request_unit' =>  $this->purchase_request_unit,
            'item_unit_type' =>  $this->unit_type,
            'item_description' =>  $this->item_description,
            'item_quantity' =>  $this->item_quantity,
            'item_unit_cost' =>  $this->item_unit_cost,
        ];
    }
}
