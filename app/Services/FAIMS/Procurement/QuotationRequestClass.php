<?php

namespace App\Services\FAIMS\Procurement;

use App\Models\FAIMS\Procurement\PurchaseRequest;
use App\Models\FAIMS\Procurement\PurchaseRequestDetail;
use App\Models\FAIMS\Procurement\Bids;
use App\Models\FAIMS\Procurement\BidsDetail;
use App\Models\FAIMS\Procurement\Supplier;
use App\Models\FAIMS\Procurement\QuotationRequest;
use App\Http\Resources\FAIMS\Procurement\QuotationRequestResource;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class QuotationRequestClass
{
    public function save($request){
        // save Request for Quotation(RFQ)
        $data = new QuotationRequest();
        $data->date =  now();
        $data->rfq_no = QuotationRequest::generateRFQNumber();
        $data->submission_not_later_than = $request->data['submission_date'];
        $data->supplier_id = $request->data['supplier_id'];
        $data->supply_officer_id = $request->data['supply_officer_id'];
        $data->purchase_request_id = $request->data['id'];
        $data->save();

        $pr = PurchaseRequest::findOrFail($request->data['id']);
        // update Purchase Request status to FOR BIDS
        $pr->status_id = 5;
        $pr->update();

        // create initial bids with 0 price
        $bid = New Bids();
        $bid->supplier_id = $data->supplier_id;
        $bid->purchase_request_id =  $data->purchase_request_id;
        $bid->status_id = 15;
        $bid->save();

        $pr_details = PurchaseRequestDetail::where('purchase_request_id', $bid->purchase_request_id )->get();
        foreach ($pr_details as $itemData) {
            BidsDetail::create([
                'bids_id' =>  $bid->id,
                'purchase_request_id' =>  $itemData['purchase_request_id'],
                'pr_detail_id' => $itemData['id'],
                'bids_description' => $itemData['item_description'],
                'bids_quantity' => $itemData['item_quantity'],
                'bids_price' => 0,
                'bids_abc' => $itemData['total'],
                'bids_unit_type_id' => $itemData['item_unit_type_id'],
                'status_id' => 10,
            ]);   
        }           

        return [
            'data' => new QuotationRequestResource($data),
            'message' => 'Request for Quotations successfuly saved!', 
            'info' => "You've successfully created the Request for Quotation.",
        ];
    }

    public function getDateSubmissionNotLaterThan($request){
     
        // get the latest RFQ created
        $submission_not_later_than = QuotationRequest::where('purchase_request_id', $request->purchase_request_id)
        ->orderBy('id', 'desc')
        ->value('submission_not_later_than');

        return  $submission_not_later_than;


    }

    public function print($id, $request){
        $date = now()->format('d F Y');

        $item_details = PurchaseRequestDetail::with('unit_type')->where('purchase_request_id', $request->purchase_request_id)->get();
        $supplier = Supplier::findOrFail($request->supplier_id);

        $supply_officer = UserProfile::findOrFail($request->supplier_officer_id);

        $data = QuotationRequest::findOrFail($id);

        $array = [
            'data' => $data,
            'supplier' => $supplier,
            'supply_officer' =>  $supply_officer,
            'submission_not_later_than' =>  (new \DateTime($data->submission_not_later_than))->format('F d, Y'),
            'date' =>  $date,
            'rfq_number' => $request->rfq_no,
            'purchase_request_number' => $request->purchase_request_number,
            'item_details' =>  $item_details,
        ];

        $pdf = \PDF::loadView('FAIMS.Procurement.printQuotation',$array)->setPaper('A4', 'portrait');
        return $pdf->stream($request->purchase_request_number.'.pdf');
    }
}
