<?php

namespace App\Http\Controllers\Modules\FAIMS\Procurement;

use Illuminate\Http\Request;
use App\Services\FAIMS\Procurement\PurchaseRequestClass;
use App\Services\FAIMS\Procurement\QuotationRequestClass;
use App\Services\FAIMS\Procurement\ViewClass;
use App\Services\FAIMS\DropdownClass;
use App\Http\Requests\FAIMS\Procurement\PurchaseRequest;
use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use setasign\Fpdi\Fpdi;

class PurchaseRequestController extends Controller
{
    use HandlesTransaction;

    public function __construct(
        QuotationRequestClass $quotation_request, 
        PurchaseRequestClass $purchase_request,
        ViewClass $view, 
        DropdownClass $dropdown
    ){
        $this->purchase_request = $purchase_request;
        $this->quotation_request = $quotation_request;
        $this->dropdown = $dropdown;
        $this->view = $view;
    }

    public function index(Request $request){
        switch($request->option){     
            case 'lists':
                return $this->view->purchase_requests($request);
            break;
            case 'unit_type':
                return $this->dropdown->unit_type($request);
            break;
            case 'sections':
                return $this->dropdown->sections($request);
            break;
            case 'supplier_address':
                return $this->dropdown->supplier_address($request->supplier_id);
            break;  
            case 'purchase_request_title':
                return $this->dropdown->purchase_request_title($request);
            break;  
            default:
                return inertia('Modules/FAIMS/Index', [
                    'dropdowns' => [
                      
                    ],
                ]); 
        }   
    }

    public function create(){
        return inertia('Modules/FAIMS/Procurement/Purchase-Request/Components/CreatePage', [
            'dropdowns' => [
                'unit_types' => $this->dropdown->unit_types(),
                'divisions' => $this->dropdown->divisions(),
                'sections' => $this->dropdown->list_sections(),
                'fund_clusters' => $this->dropdown->fund_clusters(),
                'pap_codes' => $this->dropdown->pap_codes(),
                'requesters' => $this->dropdown->requesters(),
                'approvers' => $this->dropdown->approvers(),
                'suppliers' => $this->dropdown->suppliers(),
                'supply_officers' => $this->dropdown->supply_officers(),
            ],
            'option' => 'create',
        ]); 
    }

    public function show($id, Request $request){
        return $this->view->show($id, $request);
    }

    public function store(Request $request) {
        $result = $this->handleTransaction(function () use ($request) {
            return $this->purchase_request->save($request);
        });

        return redirect()->route('purchase_request.index')->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);

    }

    
    public function update($id, Request $request) {
        $result = $this->handleTransaction(function () use ($id, $request) {
            switch($request->option){     
                case 'update':
                    return $this->purchase_request->update($id, $request);
                break;
                case 'review':
                    return $this->purchase_request->review($id, $request);
                break;
                case 'approve':
                    return $this->purchase_request->approve($id, $request);
                break;
                case 'save_bids':
                    return $this->purchase_request->save_bids($id, $request);
                break;
            }   
           
        });

        return redirect()->route('purchase_request.index')->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);

    }

       
    public function review(Request $request) {
        $result = $this->handleTransaction(function () use ($request) {
            return $this->purchase_request->review($request);
        });

        return redirect()->route('purchase_request.index')->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);

    }

         
    public function approve(Request $request) {
        $result = $this->handleTransaction(function () use ($request) {
            return $this->purchase_request->approve($request);
        });

        return redirect()->route('purchase_request.index')->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);

    }

    public function printPR($id, Request $request){
        return $this->purchase_request->printPR($id, $request);
    }
}
