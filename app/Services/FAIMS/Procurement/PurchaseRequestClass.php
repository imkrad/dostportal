<?php

namespace App\Services\FAIMS\Procurement;

use App\Models\FAIMS\Procurement\PurchaseRequest;
use App\Models\FAIMS\Procurement\PurchaseRequestDetail;
use App\Models\FAIMS\Procurement\Supplier;
use App\Models\FAIMS\Procurement\Bids;
use App\Models\FAIMS\Procurement\BidsDetail;
use App\Models\FAIMS\Procurement\QuotationRequest;
use App\Http\Resources\FAIMS\Procurement\PurchaseRequestResource;
use App\Http\Resources\FAIMS\Procurement\QuotationRequestResource;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class PurchaseRequestClass
{
    public function save($request){
        $user = Auth::user();
        $request_number = PurchaseRequest::generatePurchaseRequestNumber();
        $request_date = now();
        $data = PurchaseRequest::create(array_merge($request->all(), [ 'purchase_request_number' => $request_number,
                                                                        'purchase_request_date' => $request_date  ] ));

        // Save Purchase Request Item Details       
        $this->saveItemDetails($request, $data->id);

        return [
            'data' => new PurchaseRequestResource($data),
            'message' => 'Purchase Request creation was successful!', 
            'info' => "You've successfully created new Purchase Request.",
        ];
    }
    

    protected function saveItemDetails($request ,$purchase_request_id ){

        $unit_id =  $request->section_id;  

        foreach ($request->items as $item) {
            $item_unit_id =  $item['item_unit_id']; 
            $item_price =  $item['unit_cost']; 
            $item_qty =  $item['quantity'];  
            $item_description =  $item['description'];  
            $item_total_cost =  $item['total_cost'];  
    
            $item_details_data = new PurchaseRequestDetail();
            $item_details_data->purchase_request_id  = $purchase_request_id;
            $item_details_data->unit_id  = $unit_id;
            $item_details_data->item_unit_type_id = $item_unit_id;
            $item_details_data->item_price = $item_price;
            $item_details_data->item_quantity = $item_qty;
            $item_details_data->item_description = $item_description;
            $item_details_data->total = $item_total_cost;
            $item_details_data->status_id = 4;
            $item_details_data->save();
        }
    }
    
    public function update($id , $request)
    {

        // update Purchase Request
        $data = $this->updatePR($id , $request);

        // update Purchase Request Item Details       
        $this->updateItemDetails($id, $request , $request->data['items'] );

        return [
            'data' => new PurchaseRequestResource($data),
            'message' => 'Purchase Request updated successfuly!', 
            'info' => "You've successfully updated the Purchase Request.",
        ];
    }
    
   
    public function review($id, $request)
    {
        // update Purchase Request
        $data = $this->updatePR($id , $request);

        // update Purchase Request Item Details       
        $this->updateItemDetails($id, $request , $request->data['items'] );

        //  update status to reviewed
        $data->status_id  = 2;

        $data->update();

        return [
            'data' => new PurchaseRequestResource($data),
            'message' => 'Purchase Request reviewed successfuly!', 
            'info' => "You've successfully updated the Purchase Request.",
        ];
    }

    public function approve($id, $request)
    {
        // update Purchase Request
        $data = $this->updatePR($id , $request);

        // update Purchase Request Item Details       
        $this->updateItemDetails($id, $request , $request->data['items'] );

        //  update status to reviewed
        $data->status_id  = 3;

        $data->update();

        return [
            'data' => new PurchaseRequestResource($data),
            'message' => 'Purchase Request reviewed successfuly!', 
            'info' => "You've successfully updated the Purchase Request.",
        ];
    }
    
       
    protected function updatePR($id, $request ){
        $data = PurchaseRequest::findOrFail($id);
        $data->division_id  = $request->data['division_id'];
        $data->section_id  = $request->data['section_id'];
        $data->fund_cluster_id  = $request->data['fund_cluster_id'];
        $data->purchase_request_purpose  = $request->data['purchase_request_purpose'];
        $data->requested_by  = $request->data['requested_by'];
        $data->approved_by  = $request->data['approved_by'];    
        $data->update();

        return  $data;
    }

    protected function updateItemDetails($purchase_request_id, $request , $item_details ){
        $unit_id =  $request->data['section_id'];
           
        if($item_details){
            //  Delete all existing items for this purchase request ID
            PurchaseRequestDetail::where('purchase_request_id', $purchase_request_id)->delete();
      
            // Then, loop through the new items and add them
            foreach ($item_details as $item) {
                $item_unit_id = $item['item_unit_id'];
                $item_price = $item['unit_cost'];
                $item_qty = $item['quantity'];
                $item_description = $item['description'];
                $item_total_cost = $item['total_cost'];

                // Create a new PurchaseRequestDetail instance for each item
                $item_details_data = new PurchaseRequestDetail();
                $item_details_data->purchase_request_id = $purchase_request_id;
                $item_details_data->unit_id = $unit_id;
                $item_details_data->item_unit_type_id = $item_unit_id;
                $item_details_data->item_price = $item_price;
                $item_details_data->item_quantity = $item_qty;
                $item_details_data->item_description = $item_description;
                $item_details_data->total = $item_total_cost;
                $item_details_data->status_id = 4;
                $item_details_data->save();
            }
        }
    }

    
    public function printPR($id,$request)
    {  
        $data = PurchaseRequestDetail::with('purchase_request', 'unit_type')->where('purchase_request_id', $request->id)->get();
        $pr = PurchaseRequest::with('fundCluster','section','requester', 'requester.user_organization.position.administrative' , 'approver.user_organization.position.administrative')->where('id', $request->id)->first();

        //return $pr;
        $array = [
            'data' => $data,
            'pr_no' =>$request->purchase_request_number,
            'pr' => $pr,
        ];

        $pdf = \PDF::loadView('FAIMS.Procurement.printPR',$array)->setPaper('A4', 'portrait');
        return $pdf->stream($request->purchase_request_number.'-BAC-Resolution.pdf');
    }

  
   
}
