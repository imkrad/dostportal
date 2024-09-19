<?php

namespace App\Services\SupportTicket;

use App\Models\SupportTicket;
use App\Http\Resources\SupportTicket\SupportTicketResource;
use Illuminate\Support\Facades\Auth;

class TicketClass
{
    public function lists($request){
        $data = SupportTicketResource::collection(
            SupportTicket::query()
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('system_id', 'LIKE', "%{$keyword}%")
                      ->orWhere('requested_by', 'LIKE', "%{$keyword}%")
                      ->orWhere('request_number', 'LIKE', "%{$keyword}%")
                      ->orWhere('dv_number', 'LIKE', "%{$keyword}%")
                      ->orWhere('payee', 'LIKE', "%{$keyword}%")
                      ->orWhere('created_at', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function save($request){
        $user = Auth::user();
        $data = SupportTicket::create(array_merge($request->all(), [ 'requested_by' => $user->id  ] ));
        return [
            'data' => new SupportTicketResource($data),
            'message' => 'Support Ticket creation was successful!', 
            'info' => "You've successfully created new support ticket."
        ];
    }

    public function update($request){
        $user = Auth::user();
        $data = SupportTicket::findOrFail($request->id);
        $data->system_id = $request->system_id;
        $data->requested_by = $user->id ;
        $data->request_number = $request->request_number;
        $data->dv_number = $request->dv_number;
        $data->payee = $request->payee;
        $data->amount = $request->amount;
        $data->status = $request->status;
        $data->problem_details = $request->problem_details;
        $data->corrective_action = $request->corrective_action;
        $data->is_closed = $request->is_closed;
        $data->update();

        return [
            'data' => new SupportTicketResource($data),
            'message' => 'Support Ticket update was successful!', 
            'info' => "You've successfully updated the support ticket."
        ];
    }

}
