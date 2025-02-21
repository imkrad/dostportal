<?php

namespace App\Http\Resources\FAIMS\Procurement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UnitTypeResource;

class BidsDetailResource extends JsonResource
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
            'bids'=> $this->bids,
            'pr_detail' =>  $this->pr_detail,
            'supplier'=> $this->bids->supplier,
            'bids_description' =>  $this->bids_description,
             'bids_quantity' =>  $this->bids_quantity,
             'unit_type' =>  $this->unit_type,
             'bids_price' =>  $this->bids_price,
            // 'purchase_request' =>  $this->purchase_request,
            'remarks'  => $this->remarks ,
            //'bids_count' => $this->bids_count,
            'status' =>  $this->status,
        ];
    }
}
