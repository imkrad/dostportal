<?php

namespace App\Http\Controllers\Modules\FAIMS\Procurement;

use Illuminate\Http\Request;
use App\Services\FAIMS\Procurement\QuotationRequestClass;
use App\Services\FAIMS\Procurement\ViewClass;
use App\Services\FAIMS\DropdownClass;
use App\Http\Requests\FAIMS\Procurement\PurchaseRequest;
use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use setasign\Fpdi\Fpdi;

class QuotationRequestController extends Controller
{
    use HandlesTransaction;

    public function __construct(
        QuotationRequestClass $quotation_request, 
        ViewClass $view, 
        DropdownClass $dropdown
    ){
        $this->quotation_request = $quotation_request;
        $this->dropdown = $dropdown;
        $this->view = $view;
    }

    public function index(Request $request){
        switch($request->option){     
            case 'quotation_request':
                return $this->view->quotation_requests($request);
            break;  

            default:
                return inertia('Modules/FAIMS/Index', [
                    'dropdowns' => [
                      
                    ],
                ]); 
        }   
    }

    public function show($id, Request $request){
        return $this->view->show($id, $request);
    }

    public function create($id){
        $data = PurchaseRequest::findOrFail($id);
        return inertia('Modules/FAIMS/Procurement/Purchase-Request/Components/Quotations/CreatePage', [
            'dropdowns' => [
                'data' => $data,
            ],
            'option' => 'create',
        ]); 
    }

    public function store(Request $request) {
        $result = $this->handleTransaction(function () use ($request) {
            return $this->quotation_request->save($request);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);

    }


    public function printQuotation($id, Request $request){
        return $this->quotation_request->print($id, $request);
    }
    
}
