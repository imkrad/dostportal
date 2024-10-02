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
            'request_sai_number' =>  $this->request_sai_number,
            'purchase_request_purpose' =>  $this->purchase_request_purpose,
            'referrence_no' =>  $this->referrence_no,
            'section' =>  $this->section ? new SectionResource($this->section): null,
            'requested_by' =>  $this->requester->firstname.' '.$this->requester->middlename[0].' '.$this->requester->lastname.' '.$this->requester->suffix,
            'approved_by' =>  $this->requester->firstname.' '.$this->requester->middlename[0].' '.$this->requester->lastname.' '.$this->requester->suffix,
            'supplier_id' =>  $this->supplier ? new SupplierResource($this->supplier): null,
            'fund_cluster_id' =>  $this->fund_cluster ? new FundClusterResource($this->fund_cluster): null,
            'po_number' =>  $this->po_number,
            'pap_code' =>  $this->pap_code,
            'status' =>  $this->status,
        ];
    }
}
