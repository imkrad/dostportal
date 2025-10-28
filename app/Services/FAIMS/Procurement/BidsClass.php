<?php

namespace App\Services\FAIMS\Procurement;

use App\Models\FAIMS\Procurement\PurchaseRequest;
use App\Models\FAIMS\Procurement\Supplier;
use App\Models\FAIMS\Procurement\BidItem;
use App\Models\FAIMS\Procurement\BidOffer;
use App\Http\Resources\FAIMS\Procurement\BidsResource;
use App\Http\Resources\FAIMS\Procurement\BidsDetailResource;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class BidsClass
{
    public function save($request)
    {
        $data = Bids::create([
            'supplier_id' =>  $request->data['supplier_id'],
            'purchase_request_id' => $request->data['pr_id'],
            'status_id' => 9,
        ]);

        foreach ($request->data['items'] as $itemData) {
            BidsDetail::create([
                'bids_id' => $data->id,
                'purchase_request_id' =>  $request->data['pr_id'],
                'pr_detail_id' => $itemData['value'],
                'bids_description' => $itemData['description'],
                'bids_quantity' => $itemData['quantity'],
                'bids_price' => $itemData['item_bid_price'],
                'bids_abc' => $itemData['total_cost'],
                'bids_unit_type_id' => $itemData['item_unit_id'],
                'pr_detail_id' => $itemData['value'],
                'status_id' => 7,
            ]);   
        }

        return [
            'data' =>new BidsResource($data),
            'message' => 'Item bid price set successfuly!', 
            'info' => "You've successfully set the Item Bid Price.",
        ];
    }

    public function save_bid_offer($request){
        $bid_item = BidOffer::where('bid_item_id', $request->id)->firstOrFail();
        if($bid_item){
            // update bid offer for bid_item
            $bid_item->item_bid_price = $request->item_bid_price;
            $bid_item->technical_proposal = $request->technical_proposal;
            $bid_item->delivery_term = $request->delivery_term;
            $bid_item->update();
        }

        return [
            'data' => $bid_item,
            'message' => 'Bid Offer updated successfuly!', 
            'info' => "You've successfully updated the Bid Offer.",
        ];
    }
    
  
    public function save_bid_for_award($request){
        $purchase_request = PurchaseRequest::findOrFail($request->purchase_request_id);
        foreach ($request->items as $item) {
            $bid_item = BidItem::findOrFail($item['bid_item_id']);
            if($bid_item){
                // update bid item status to "Awarded" 
                $bid_item->status_id = 8;
                $bid_item->update();
            }
        }

        foreach ($request->itemsNotAvailableForAward as $item) {
            $bid_item = BidItem::findOrFail($item['bid_item_id']);
            $bid_offer = BidOffer::findOrFail($item['bid_item_id']);
            if($bid_item && $bid_offer){
                if (!empty($bid_offer->item_bid_price)) {
                    // update bid item status to "Available for Re-award" 
                    $bid_item->status_id = 9;
                    $bid_item->update();
                }
                else{
                    // update bid item status to "Not Available for Award/Re-award" 
                    $bid_item->status_id = 11;
                    $bid_item->update();
                }
             
            }
        }

        // if PR exist
        if($purchase_request){
                // update PR status to "For BAC Resolution" 
                $purchase_request->status_id = 6;
                $purchase_request->update();
        }

        return [
            'data' => $request->items,
            'message' => 'Bid Items awarded successfuly!', 
            'info' => "You've successfully awarded the Bid Items.",
        ];
    }

    

    public function print($id,$request){
        $data = BidsDetail::with('bids','bids.supplier','unit_type')->where('purchase_request_id', $request->pr_id)
        ->select('pr_detail_id', 'bids_id', 'bids_quantity', 'bids_unit_type_id', 'bids_price', 'bids_description')
        ->orderBy('pr_detail_id', 'asc')
        ->get()
        ->groupBy('pr_detail_id'); // Group by pr_detail_id

        $array = [
            'data' => $data,
            'pr_no' =>$request->purchase_request_number
        ];

        $pdf = \PDF::loadView('FAIMS.Procurement.printBids',$array)->setPaper('A4', 'landscape');
        return $pdf->stream($request->purchase_request_number.'.pdf');
    }

    public function printPO($id,$request){
        $data = BidsDetail::with('bids','bids.supplier','unit_type')->where('purchase_request_id', $request->pr_id)
        ->select('pr_detail_id', 'bids_id', 'bids_quantity', 'bids_unit_type_id', 'bids_price', 'bids_description')
        ->orderBy('pr_detail_id', 'asc')
        ->get()
        ->groupBy('pr_detail_id'); // Group by pr_detail_id

        $array = [
            'data' => $data,
            'pr_no' =>$request->purchase_request_number
        ];

        $pdf = \PDF::loadView('FAIMS.Procurement.printPO',$array)->setPaper('A4', 'portrait');
        return $pdf->stream($request->purchase_request_number.'.pdf');
    }



    





   
}
