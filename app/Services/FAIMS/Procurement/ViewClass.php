<?php

namespace App\Services\FAIMS\Procurement;

use App\Services\FAIMS\Procurement\BidsClass;
use App\Services\FAIMS\DropdownClass;
use App\Models\FAIMS\Procurement\PurchaseRequest;
use App\Models\FAIMS\Procurement\QuotationRequest;
use App\Models\FAIMS\Procurement\PurchaseRequestDetail;
use App\Http\Resources\FAIMS\Procurement\PurchaseRequestResource;
use App\Http\Resources\FAIMS\Procurement\QuotationRequestResource;
use Illuminate\Support\Facades\Auth;




class ViewClass
{
    public function __construct( DropdownClass $dropdown, BidsClass $bids){
        $this->dropdown = $dropdown;
        $this->bids = $bids;
    }

    public function purchase_requests($request){
        $data = PurchaseRequestResource::collection(
            PurchaseRequest::with('section.division')
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

    public function quotation_requests($request){
        $data = QuotationRequestResource::collection(
            QuotationRequest::query()
            ->with('supplier' ,'supply_officer')
            ->where('purchase_request_id', $request->purchase_request_id)
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('rfq_no', 'LIKE', "%{$keyword}%")
                      ->orWhere('date', 'LIKE', "%{$keyword}%")
                       ->orWhereHas('supplier',function ($query) use ($keyword) {
                            $query->where('name', 'LIKE', "%{$keyword}%");
                        })->orWhereHas('supply_officer',function ($query) use ($keyword) {
                            $query->where('name', 'LIKE', "%{$keyword}%");
                        })  
                        ->orWhere('created_at', 'LIKE', "%{$keyword}%")
                      ->orWhere('updated_at', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );

        return $data;
    }

    public function show($id, $request){
        $purchase_request = PurchaseRequest::with('section', 'pap_codes')->findOrFail($id);
        $pap_code_ids = $purchase_request->pap_codes()->pluck('list_pap_code_id');
        switch($request->option){
            case 'edit':
            case 'review':
            case 'approve':
                return inertia('Modules/FAIMS/Procurement/Purchase-Request/Components/CreatePage', [
                    'dropdowns' => [
                        'pap_code_ids' => $pap_code_ids,
                        'unit_types' => $this->dropdown->unit_types(),
                        'divisions' => $this->dropdown->divisions(),
                        'sections' => $this->dropdown->list_sections(),
                        'fund_clusters' => $this->dropdown->fund_clusters(),
                        'requesters' => $this->dropdown->requesters(),
                        'approvers' => $this->dropdown->approvers(),
                        'suppliers' => $this->dropdown->suppliers(),
                        'pap_codes' => $this->dropdown->pap_codes(),
                        'supply_officers' => $this->dropdown->supply_officers(),
                    ],
                    'purchase_request' => $purchase_request,
                    'items' => $this->dropdown->pr_items($id),
                    'option' => $request->option,
                ]); 
            break;
            case 'bids':
                return inertia('Modules/FAIMS/Procurement/Purchase-Request/Components/Bids/Lists', [
                    'dropdowns' => [
                        'suppliers' => $this->dropdown->suppliers(),
                        'lists' => $this->bids->lists($id,$request),
                    ],
                    'purchase_request' => $purchase_request, 
                    'items' => $this->dropdown->pr_items($id),       
                    'bid_items' => $this->dropdown->bid_items($id),
                    'option' => $request->option,
                ]); 
            break;
            // case 'awards':
            //     return inertia('Modules/FAIMS/Procurement/Purchase-Request/Components/Awards/Lists', [
            //         'dropdowns' => [
            //             'purchase_request' => $purchase_request,
            //             'item_details' => $this->dropdown->pr_details($id),
            //             'suppliers' => $this->dropdown->suppliers(),
            //             'lists' => $this->bids->lists($id,$request),
            //         ],        
            //         'option' => $request->option,
            //     ]); 
            // break;
            case 'quotations':
                return inertia('Modules/FAIMS/Procurement/Purchase-Request/Components/Quotations/Lists', [
                    'purchase_request' => $purchase_request,
                    'option' => $request->option,
                ]); 
            break;
            case 'bac_resolutions':
                return inertia('Modules/FAIMS/Procurement/Purchase-Request/Components/BAC-Resolutions/Lists', [
                    'dropdowns' => [
                       'purchase_request' => $purchase_request,
                       'bids' => $this->dropdown->bids($id),
                    ],
                    'option' => $request->option,
                ]); 
            break;
            case 'create_rfq':
                return inertia('Modules/FAIMS/Procurement/Purchase-Request/Components/Quotations/CreatePage', [
                    'dropdowns' => [
                       'suppliers' => $this->dropdown->suppliers(),
                       'supply_officers' => $this->dropdown->supply_officers(),
                    ],
                    'purchase_request' => $purchase_request,
                    'items' => $this->dropdown->pr_items($id),
                    'option' => $request->option,
                ]); 
            break;


        }
    }
}
