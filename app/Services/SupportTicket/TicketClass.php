<?php

namespace App\Services\SupportTicket;

use App\Models\SupportTicket;
use App\Http\Resources\DefaultResource;

class TicketClass
{
    public function lists($request){
        $data = DefaultResource::collection(
            SupportTicket::query()
            ->with('main')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%")
                ->orWhereHas('main',function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                });
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    // public function save($request){
    //     $data = ListUnit::create($request->all());
    //     return [
    //         'data' => new DefaultResource($data),
    //         'message' => 'Unit creation was successful!', 
    //         'info' => "You've successfully created new unit."
    //     ];
    // }

}
