<?php

namespace App\Services\FAIMS\Procurement;

use App\Models\FAIMS\Procurement\PurchaseRequest;
use App\Models\FAIMS\Procurement\PurchaseRequestDetail;

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

        return [
            'data' => new QuotationRequestResource($data),
            'message' => 'Request for Quotations successfuly saved!', 
            'info' => "You've successfully created the Request for Quotation.",
        ];
    }

    public function print($id, $request){
        $date = now()->format('d F Y');

        // $data = PurchaseRequest::findOrFail($id);
        $item_details = PurchaseRequestDetail::with('unit_type')->where('purchase_request_id', $request->purchase_request_id)->get();
        $supplier = Supplier::findOrFail($request->supplier_id);
        $supply_officer = UserProfile::findOrFail($request->supplier_officer_id);

        // $search_data = [
        //     'purchase_request_number' => $request->purchase_request_number,
        //     'address' => $request->address,
        //     'date_submitted' => (new \DateTime($request->date_submitted))->format('F d, Y'),
        //     'purchase_request_date' => $request->purchase_request_date,
        // ];

        // $search_data = json_encode($search_data);
        // $decoded_data = json_decode($search_data, true);

        $data = QuotationRequest::findOrFail($id);

        $array = [
            'data' => $data,
            'supplier' => $supplier,
            'supply_officer' =>  $supply_officer,
            // 'search_data' =>   $decoded_data,  
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
