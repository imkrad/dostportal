<?php

namespace App\Services\FAIMS\Procurement;

use App\Models\FAIMS\Libraries\ListPAPCode;
use App\Models\FAIMS\Libraries\PAPCodeEndUser;
use App\Http\Resources\FAIMS\Libraries\PAPCodeResource;
use Illuminate\Support\Facades\Auth;

class PAPCodeClass
{
    public function lists($request){
        $data = PAPCodeResource::collection(
            ListPAPCode::query()
            ->with('end_users.end_user')
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
        // Create the PAP Code with the correct syntax
        $pap_code = ListPAPCode::create($request->only(
                'title', 
                'code', 
                'year', 
                'allocated_budget',
                'app_type_id',
                'mode_of_procurement_id'
            )
        );


        // Loop through end_user_ids and save them
        foreach ($request->end_user_ids as $end_user_id) {
            PAPCodeEndUser::create([
                'pap_code_id' => $pap_code->id,
                'end_user_id' => $end_user_id,
            ]);
        }

        // Wrap the newly created PAPCode in a Resource
        return [
            'data' => new PAPCodeResource($pap_code),
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
            'mode_of_procurement_id' => $request->mode_of_procurement_id,
        ]);
    
        return [
            'data' => new PAPCodeResource($data),
            'message' => 'PAP Code updated successfully!',
            'info' => "You've successfully updated the PAP Code.",
        ];
    }
   
}
