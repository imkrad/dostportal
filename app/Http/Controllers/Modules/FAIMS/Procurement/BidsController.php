<?php

namespace App\Http\Controllers\Modules\FAIMS\Procurement;

use Illuminate\Http\Request;
use App\Services\FAIMS\Procurement\BidsClass;
use App\Services\FAIMS\Procurement\ViewClass;
use App\Services\FAIMS\DropdownClass;
use App\Http\Requests\FAIMS\Procurement\PurchaseRequest;
use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use setasign\Fpdi\Fpdi;

class BidsController extends Controller
{
    use HandlesTransaction;

    public function __construct(
        BidsClass $bids, 
        ViewClass $view, 
        DropdownClass $dropdown
    ){
        $this->bids = $bids;
        $this->dropdown = $dropdown;
        $this->view = $view;
    }

    public function index(Request $request){
        switch($request->option){     
            case 'lists':
                return $this->view->lists($request);
            break;  
            case 'submission_not_later_than':
                return $this->dropdown->submission_not_later_than($request);
            break;
            
        }   
    }

    public function show($id, Request $request){
        return $this->view->show($id, $request);
    }

    public function store(Request $request) {
        switch($request->option){     
            case 'save_award':
                $result = $this->handleTransaction(function () use ($request) {
                    return $this->bids->save_award($request);
                });
            break;   
            case 'save_bid_offer':
                $result = $this->handleTransaction(function () use ($request) {
                    return $this->bids->save_bid_offer($request);
                });
            break;  
            case 'save_bid_for_award':
                $result = $this->handleTransaction(function () use ($request) {
                    return $this->bids->save_bid_for_award($request);
                });
            break;   
            default:
                $result = $this->handleTransaction(function () use ($request) {
                    return $this->bids->save($request);
                });
            break;         
        }  
        
        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);


    }







    public function printBids($id, Request $request){
        return $this->bids->print($id, $request);
    }

    public function printPO($id, Request $request){
        return $this->bids->printPO($id, $request);
    }



    

    
}
