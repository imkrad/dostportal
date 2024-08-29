<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
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
            'special_id' => $this->special_id,
            'administrative_id' => $this->administrative_id,
            'salary_id' => $this->salary_id,
            'special' => ($this->special) ? $this->special->name : '-',
            'administrative' => $this->administrative->name,
            'grade' => $this->salary->grade,
            'salary' => $this->salary->amount,
        ];
    }
}
