<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HrRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        switch($this->option){
            case 'rate':
                return [
                    'special_id' => 'nullable',
                    'administrative_id' => 'required',
                    'salary_id' => 'required'
                ];
            break;
            case 'unit':
                return [
                    'name' => 'nullable',
                    'short' => 'required',
                    'unit_id' => 'required'
                ];
            break;
            default: 
                return [];
        }
    }
}
