<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupportTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'system' => 'required',
            'request_number' => 'sometimes|required|string|max:100',
            'dv_number' => 'sometimes|required|string|max:100',
            'payee' => 'sometimes|required|string|max:100',
            'amount' => 'sometimes|request|integer',
            'status' => 'sometimes|required|string|max:6',
            'problem_details' => 'sometimes|required',
            'corrective_action' => 'sometimes|nullable',
        ];
    }
}
