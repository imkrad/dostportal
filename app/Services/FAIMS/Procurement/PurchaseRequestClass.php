<?php

namespace App\Services\FAIMS\Procurement;

use App\Models\FAIMS\Procurement\PurchaseRequest;
use App\Models\FAIMS\Procurement\PurchaseRequestItemDetail;
use App\Http\Resources\FAIMS\Procurement\PurchaseRequestResource;
use Illuminate\Support\Facades\Auth;

class PurchaseRequestClass
{
    public function lists($request){
        $data = PurchaseRequestResource::collection(
            PurchaseRequest::query()
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('purchase_request_number', 'LIKE', "%{$keyword}%")
                      ->orWhere('purchase_request_date', 'LIKE', "%{$keyword}%")
                      ->orWhere('created_at', 'LIKE', "%{$keyword}%")
                      ->orWhere('updated_at', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function save($request){
        //dd($request->all());
        $user = Auth::user();
        $request_number = PurchaseRequest::generatePurchaseRequestNumber();
        $request_date = now();
        $data = PurchaseRequest::create(array_merge($request->all(), [ 'purchase_request_number' => $request_number,
                                                                        'purchase_request_date' => $request_date  ] ));
        //dd($request->items);
        // Save Purchase Request Item Details       
   
        $this->saveItemDetails($request);

        return [
            'data' => new PurchaseRequestResource($data),
            'message' => 'Purchase Request creation was successful!', 
            'info' => "You've successfully created new Purchase Request.",
        ];
    }

    protected function saveItemDetails($request){

        $unit_id =  $request->section_id;  

        foreach ($request->items as $item) {
            $item_unit_id =  $item['item_unit_id']; 
            $item_price =  $item['unit_cost']; 
            $item_qty =  $item['quantity'];  
            $item_description =  $item['description'];  
            $item_total_cost =  $item['total_cost'];  
    
            $item_details_data = new PurchaseRequestItemDetail();
            $item_details_data->unit_id  = $unit_id;
            $item_details_data->item_unit_type_id = $item_unit_id;
            $item_details_data->item_price = $item_price;
            $item_details_data->item_quantity = $item_qty;
            $item_details_data->item_description = $item_description;
            $item_details_data->total = $item_total_cost;
            $item_details_data->status_id = 1;
            $item_details_data->save();
        }

    }
}
