<?php

namespace App\Services\FAIMS\Procurement;

use App\Models\FAIMS\Procurement\Supplier;
use App\Models\FAIMS\Procurement\Bids;
use App\Models\FAIMS\Procurement\BidsDetail;
use App\Http\Resources\FAIMS\Procurement\BidsResource;
use App\Http\Resources\FAIMS\Procurement\BidsDetailResource;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class BidsClass
{
    public function lists($id, $request){
        $data = BidsResource::collection(
            Bids::query()
            ->with('bids_details','bids_details.unit_type','bids_details.status','status')
            ->where('purchase_request_id', $id)
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('created_at', 'LIKE', "%{$keyword}%")
                        ->orWhere('updated_at', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );

        return $data;
    }



    public function save($request)
    {
        //dd($request->all());
        //dd($request->data['items']);

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

    public function print($id,$request){
        //dd($request->all());

        // $bids_ids = Bids::where('purchase_request_id',$request->pr_id)
        // ->pluck('id');

        $data = BidsDetail::with('bids','bids.supplier','unit_type')->where('purchase_request_id', $request->pr_id)
        ->select('pr_detail_id', 'bids_id', 'bids_quantity', 'bids_unit_type_id', 'bids_price', 'bids_description')
        ->orderBy('pr_detail_id', 'asc')
        ->get()
        ->groupBy('pr_detail_id'); // Group by pr_detail_id

 

       
    
// return  $data;
        $array = [
            'data' => $data,
            'pr_no' =>$request->purchase_request_number
        ];

        $pdf = \PDF::loadView('FAIMS.Procurement.printBids',$array)->setPaper('A4', 'landscape');
        return $pdf->stream($request->purchase_request_number.'.pdf');
    }


   
}
