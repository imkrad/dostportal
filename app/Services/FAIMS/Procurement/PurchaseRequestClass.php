<?php

namespace App\Services\FAIMS\Procurement;

use App\Models\FAIMS\Procurement\PurchaseRequest;
use App\Models\FAIMS\Procurement\PurchaseRequestItem;
use App\Models\FAIMS\Procurement\Supplier;
use App\Models\FAIMS\Procurement\Bids;
use App\Models\FAIMS\Procurement\BidsDetail;
use App\Models\FAIMS\Procurement\QuotationRequest;
use App\Models\FAIMS\Procurement\PRPAPCode;
use App\Http\Resources\FAIMS\Procurement\PurchaseRequestResource;
use App\Http\Resources\FAIMS\Procurement\QuotationRequestResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PurchaseRequestClass
{
    public function save($request){

        $user = Auth::user();
        $purchase_request_number = PurchaseRequest::generatePurchaseRequestNumber();
        $data = PurchaseRequest::create(array_merge($request->all(), [ 'purchase_request_number' => $purchase_request_number, ] ));

        if (!empty($request->pap_code_ids) && is_array($request->pap_code_ids)) {
            // Save PAP codes
            foreach ($request->pap_code_ids as $pap_code_id) {
                $pap_code = new PRPAPCode();
                $pap_code->list_pap_code_id = $pap_code_id;
                $pap_code->purchase_request_id = $data->id;
                $pap_code->save();
            }
        }
                                                                        
        // Save Purchase Request Item Details       
        $this->savePRItems($request, $data->id);

        return [
            'data' => new PurchaseRequestResource($data),
            'message' => 'Purchase Request creation was successful!', 
            'info' => "You've successfully created new Purchase Request.",
        ];
    }
    

    protected function savePRItems($request ,$purchase_request_id ){
        foreach ($request->items as $index => $item) {
            $data = new PurchaseRequestItem();
            $data->item_no = $index + 1;
            $data->purchase_request_id  = $purchase_request_id;
            $data->item_unit_type_id =  $item['item_unit_type_id'];
            $data->item_unit_cost = $item['item_unit_cost'];
            $data->item_quantity = $item['item_quantity'];
            $data->item_description = $item['item_description'];
            $data->total_cost = $item['total_cost'];
            $data->save();
        }

    }
    
    public function update($id , $request)
    {
        // update Purchase Request
        $data = $this->updatePR($id , $request);

        // update Purchase Request Item Details       
        $this->updatePRItems($id, $request , $request);

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
        $this->updatePRItems($id, $request);

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
        $this->updatePRItems($id, $request);

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

        $data->update(array_merge($request->only(
            'purchase_request_purpose',
            'purchase_request_title',
            'division_id',
            'section_id',
            'fund_cluster_id',
            'approved_by_id'
        )));

        return  $data;
    }

    protected function updatePRItems($id, $request ){
  
        $data = PurchaseRequestItem::findOrFail($id);
  
        $data->update(array_merge($request->only(
            'item_description',
            'item_unit_type_id',
            'item_quantity',
            'item_unit_cost',
            'total_cost',
        )));

        return  $data;
    }

    public function regional_director(){
        //  fetch user with role id 4 or regionaldirector
       $data = User::with('user_roles' , 'profile')
        ->whereHas('user_roles', function ($query) {
            $query->where('role_id', 4);
        })->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->profile->firstname.' '.$item->profile->middlename[0].'. '.$item->profile->lastname.' '.$item->profile->suffix ,
            ];
        });
        return $data;
    }

    

    
    public function printPR($id,$request)
    {  
        $data = PurchaseRequestItem::with('purchase_request', 'unit_type')->where('purchase_request_id', $request->id)->get();
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
