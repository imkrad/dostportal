<?php

namespace App\Services\FAIMS\Procurement;

use App\Models\FAIMS\Libraries\ListPAPCode;
use App\Http\Resources\FAIMS\Libraries\PAPCodeResource;
use Illuminate\Support\Facades\Auth;

class PAPCodeClass
{
    public function lists($request){
        $data = PAPCodeResource::collection(
            ListPAPCode::query()
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('title', 'LIKE', "%{$keyword}%")
                        ->orWhere('code', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );

        return $data;
    }

    public function save($request)
    { 
        $data = ListPAPCode::create([
            'title' =>  $request->title,
            'code' => $request->code,
            'allocated_budget' =>  $request->allocated_budget,
        ]);


        return [
            'data' =>new PAPCodeResource($data),
            'message' => 'PAP Code created successfully!', 
            'info' => "You've successfully added new PAP Code.",
        ];
    }

    public function update($request, $id)
    {

        // Find the record by its ID
        $data = ListPAPCode::findOrFail($id);

        // Update the record with the provided data
        $data->update([
            'title' => $request->title,
            'code' => $request->code,
            'allocated_budget' => $request->allocated_budget,
        ]);
    
        return [
            'data' => new PAPCodeResource($data),
            'message' => 'PAP Code updated successfully!',
            'info' => "You've successfully updated the PAP Code.",
        ];
    }
   
}
