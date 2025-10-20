<?php

namespace App\Http\Resources\FAIMS\Libraries;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
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
            'address' =>  $this->address,
            'contact' =>  $this->contact,
            'philgeps_registration_no' =>  $this->philgeps_registration_no,
            'mayors_permit_no' =>  $this->mayors_permit_no,
            'tin' =>  $this->tin,
            'code' =>  $this->code,
        ];
    }
}
