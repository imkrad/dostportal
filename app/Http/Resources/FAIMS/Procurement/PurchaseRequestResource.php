<?php

namespace App\Http\Resources\FAIMS\Procurement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class PurchaseRequestResource extends JsonResource
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
            'purchase_request_number' =>  $this->purchase_request_number,
            'purchase_request_date' => $this->purchase_request_date,
            'purchase_request_purpose' =>  $this->purchase_request_purpose,
            'purchase_request_title' =>  $this->purchase_request_title,
            'section' =>  $this->section,
            'division' =>  $this->division,
            'fund_cluster' =>  $this->fund_cluster,
            'requested_by' => $this->requested_by->profile->full_name ,
            'approved_by' =>  $this->approved_by,
            'pap_codes' =>  $this->pap_codes,
            'quotation_count'  => $this->quotation_count,
            'reawarded_count'  => $this->reawarded_count,
            'rebidded_count'  => $this->rebidded_count,
            'status' =>  $this->status,
        ];
    }
}
