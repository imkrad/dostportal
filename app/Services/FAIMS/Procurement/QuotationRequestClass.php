<?php

namespace App\Services\FAIMS\Procurement;

use App\Models\FAIMS\Procurement\PurchaseRequest;
use App\Models\FAIMS\Procurement\PurchaseRequestDetail;
use App\Models\FAIMS\Procurement\Bid;
use App\Models\FAIMS\Procurement\BidItem;
use App\Models\FAIMS\Procurement\BidOffer;
use App\Models\FAIMS\Procurement\Supplier;
use App\Models\FAIMS\Procurement\QuotationRequest;
use App\Http\Resources\FAIMS\Procurement\QuotationRequestResource;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class QuotationRequestClass
{
    public function save($request){
        //dd($request->all());

        // create initial bids 
        foreach ($request->supplier_ids as $supplier_id) {

            // save Request for Quotation(RFQ)
            $rfq_no= QuotationRequest::generateRFQNumber();

            $quotation_request = new QuotationRequest();
            $quotation_request->submission_not_later_than = $request->submission_not_later_than;
            $quotation_request->supply_officer_id = $request->supply_officer_id;
            $quotation_request->purchase_request_id = $request->purchase_request_id;
            $quotation_request->rfq_no = $rfq_no;
            $quotation_request->supplier_id = $supplier_id;
            $quotation_request->status_id = 19; 
            $quotation_request->save();


            //create initital bid
            $bid = new Bid();
            $bid->purchase_request_id = $request->purchase_request_id;
            $bid->quotation_request_id = $quotation_request->id;
            $bid->save();


            // and bid items 
            foreach ($request->items as $item) {
                // create initial bid item
                $bid_item = new BidItem();
                $bid_item->bid_id = $bid->id;
                $bid_item->pr_item_id = $item['value'];
                $bid_item->status_id = 9; // set status to "available for award"
                $bid_item->save();

                dd($bid_item);

                // create initial bid offer
                $bid_offer = new BidOffer();
                $bid_offer->bid_item_id = $bid_item->id;
                $bid_offer->save();
            }
        }

        $purchase_request = PurchaseRequest::findOrFail($request->purchase_request_id);
        // update Purchase Request status to 'FOR BIDS'
        $purchase_request->quotation_count = $purchase_request->quotation_count+1;
        $purchase_request->status_id = 4;
        $purchase_request->update();

       

        return [
            'data' => new QuotationRequestResource($quotation_request),
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
