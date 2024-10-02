<?php

namespace App\Http\Requests\FAIMS\Procurement;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'purchase_request_number' => 'sometimes|required|string|max:100',
            'request_sai_number' => 'nullable|string|max:100',
            'purchase_request_purpose' => 'required|string|max:100',
            'referrence_no' => 'nullable|string|max:100',
            'division_id' => 'sometimes|required|max:20|unique:list_dropdowns,division_id,'.$this->id,
            'section_id' => 'sometimes|required|max:20|unique:sections,section_id,'.$this->id,
            'requested_by' => 'sometimes|required|max:20|unique:users,requested_by,'.$this->id,
            'approved_by' => 'sometimes|required|max:20|unique:users,approved_by,'.$this->id,
            'supplier_id' => 'sometimes|required|max:20|unique:suppliers,supplier_id,'.$this->id,
            'po_number' => 'sometimes|required|string|max:20',
            'pap_code' => 'sometimes|required|string|max:20',
            'status_id' => 'sometimes|required|max:20|unique:purchase_request_statuses,status_id,'.$this->id,
        ];
    }
}
