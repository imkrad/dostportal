<?php

namespace App\Services\FAIMS\Procurement;

use App\Models\FAIMS\Libraries\Supplier;
use App\Http\Resources\FAIMS\Libraries\SupplierResource;
use Illuminate\Support\Facades\Auth;

class SupplierClass
{
    public function lists($request){
        $data = SupplierResource::collection(
            Supplier::query()
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
        $code = Supplier::generateCode();
        $data = Supplier::create(array_merge($request->all(), [ 'code' => $code ]));

        return [
            'data' =>new SupplierResource($data),
            'message' => 'Supplier created successfully!', 
            'info' => "You've successfully added new Supplier.",
        ];
    }

    public function update($request, $id)
    {
        // Find the record by its ID
        $data = Supplier::findOrFail($id);

        // Update the record with the provided data
        $data->update([
            'name' =>  $request->name,
            'mayors_permit_no' => $request->mayors_permit_no,
            'tin' =>  $request->tin,
            'philgeps_registration_no' => $request->philgeps_registration_no,
            'address' => $request->address,
            'contact' => $request->contact,
        ]);
    
        return [
            'data' => new SupplierResource($data),
            'message' => 'Supplier updated successfully!',
            'info' => "You've successfully updated the Supplier.",
        ];
    }
   
}
