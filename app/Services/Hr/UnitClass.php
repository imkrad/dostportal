<?php

namespace App\Services\Hr;

use App\Models\ListUnit;
use App\Http\Resources\DefaultResource;

class UnitClass
{
    public function lists($request){
        $data = DefaultResource::collection(
            ListUnit::query()
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

    public function save($request){
        $data = ListUnit::create($request->all());
        return [
            'data' => new DefaultResource($data),
            'message' => 'Unit creation was successful!', 
            'info' => "You've successfully created new unit."
        ];
    }

    public function update($request){
        $data = ListUnit::findOrFail($request->id);
        $data->name = $request->name;
        $data->unit_id = $request->unit_id;
        $data->save();

        return [
            'data' => new DefaultResource($data),
            'message' => 'Unit update was successful!', 
            'info' => "You've successfully updated the unit."
        ];
    }
}
