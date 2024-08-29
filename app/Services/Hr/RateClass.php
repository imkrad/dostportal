<?php

namespace App\Services\Hr;

use App\Models\ListPosition;
use App\Http\Resources\HR\RateResource;

class RateClass
{   
    public function lists($request){
        $data = RateResource::collection(
            ListPosition::query()
            ->with('special','administrative','salary')
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('special',function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                })->orWhereHas('administrative',function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                })->orWhereHas('salary',function ($query) use ($keyword) {
                    $query->where('grade', 'LIKE', "%{$keyword}%");
                });
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function save($request){
        $data = ListPosition::create($request->all());
        return [
            'data' => new RateResource($data),
            'message' => 'Salary Rate creation was successful!', 
            'info' => "You've successfully created new salary rate."
        ];
    }

    public function update($request){
        $data = ListPosition::findOrFail($request->id);
        $data->special_id = $request->special_id;
        $data->administrative_id = $request->administrative_id;
        $data->salary_id = $request->salary_id;
        $data->save();

        return [
            'data' => new RateResource($data),
            'message' => 'Salary Rate update was successful!', 
            'info' => "You've successfully updated the salary rate."
        ];
    }
}
