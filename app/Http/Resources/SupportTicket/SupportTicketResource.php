<?php

namespace App\Http\Resources\SupportTicket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class SupportTicketResource extends JsonResource
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
            'system' =>  $this->system ? new SystemResource($this->system): null,
            'requested_by' =>  $this->requester ? new UserResource($this->requester): null,
            'requested_date' => $this->created_at->format('m/d/Y'),
            'request_number' => $this->request_number,
            'dv_number' => $this->dv_number,
            'payee' => $this->payee,
            'amount' =>  $this->amount,
            'status' => $this->status,
            'problem_details' => $this->problem_details,
            'corrective_action' => $this->corrective_action,
            'is_closed' => $this->is_closed,
        ];
    }
}
