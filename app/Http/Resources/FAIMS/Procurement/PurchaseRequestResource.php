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
            'referrence_no' =>  $this->referrence_no,
            'section' =>  $this->section,
            'division' =>  $this->division,
            'requested_by' =>  $this->requester->firstname.' '.$this->requester->middlename[0].' '.$this->requester->lastname.' '.$this->requester->suffix,
            'requested_by_id' =>  $this->requester->id,
            'approved_by' =>  $this->approver->firstname.' '.$this->requester->middlename[0].' '.$this->requester->lastname.' '.$this->requester->suffix,
            'approved_by_id' =>  $this->approver->id,
            'supplier' =>  $this->supplier,
            'fund_cluster' =>  $this->fundCluster,
            'po_number' =>  $this->po_number,
            'pap_codes' =>  $this->pap_codes,
            'status' =>  $this->status,
        ];
    }
}
