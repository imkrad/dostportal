<?php

namespace App\Services\FAIMS\Procurement;

use App\Models\FAIMS\Procurement\BacResolution;
use App\Models\FAIMS\Procurement\PurchaseRequest;
use App\Http\Resources\FAIMS\Procurement\BACResolutionResource;
use Illuminate\Support\Facades\Auth;

class BACResolutionClass
{
    public function lists($request){
        $data = BACResolutionResource::collection(
            BacResolution::query()
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('bac_resolution_number', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );

        return $data;
    }

    public function save($request)
    { 
        //dd($request->all());
        $user = Auth::user();
        $bac_reso__number = BacResolution::generateBACResolutionNumber();

        $data = BacResolution::create([
            'bac_resolution_number' => $bac_reso__number,
            'body' => $request->body,
            'purchase_request_id' => $request->purchase_request_id,
            'created_by_id' => $user->id,
        ]);

        $purchase_request = PurchaseRequest::findOrFail($request->purchase_request_id);
        if($purchase_request){
             // update PR status to For NOA 
             $purchase_request->status_id = 8;
             $purchase_request->update();
        }

        return [
            'data' =>new BACResolutionResource($data),
            'message' => 'BAC Resolution created successfully!', 
            'info' => "You've successfully added new BAC Resolution.",
        ];
    }

    
    public function printBACReso($id)
    {  
        $data = BACResolution::findOrFail($id);

        $array = [
            'data' => $data,
        ];

        $pdf = \PDF::loadView('FAIMS.Procurement.printBACReso',$array)->setPaper('A4', 'portrait');
        return $pdf->stream($data->bac_resolution_number.'-BAC-Resolution.pdf');
    }

   
}
