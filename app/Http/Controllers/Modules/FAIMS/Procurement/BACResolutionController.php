<?php

namespace App\Http\Controllers\Modules\FAIMS\Procurement;

use Illuminate\Http\Request;
use App\Services\FAIMS\Procurement\BACResolutionClass;
use App\Services\FAIMS\Procurement\ViewClass;
use App\Services\FAIMS\DropdownClass;
use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use setasign\Fpdi\Fpdi;

class BACResolutionController extends Controller
{
    use HandlesTransaction;

    public function __construct(
        BACResolutionClass $bac_resolution, 
        ViewClass $view, 
        DropdownClass $dropdown
    ){
        $this->bac_resolution = $bac_resolution;
        $this->dropdown = $dropdown;
        $this->view = $view;
    }

    public function index(Request $request){
        switch($request->option){     
            case 'lists':
                return $this->bac_resolution->lists($request);
            break;  
            
        }   
    }

    public function show($id, Request $request){
        return $this->view->show($id, $request);
    }

    public function store(Request $request) {
        $result = $this->handleTransaction(function () use ($request) {
            return $this->bac_resolution->save($request);
        });
        
        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);


    }

    public function printBACReso($id){
        return $this->bac_resolution->printBACReso($id);
    }

    

    
}
