<?php

namespace App\Http\Controllers\Modules\FAIMS\Procurement;

use Illuminate\Http\Request;
use App\Services\FAIMS\DropdownClass;
use App\Traits\HandlesTransaction;
use App\Services\FAIMS\Procurement\PAPCodeClass;
use App\Http\Controllers\Controller;
use setasign\Fpdi\Fpdi;

class PAPCodeController extends Controller
{
    use HandlesTransaction;

    public function __construct(
        PAPCodeClass $pap_codes, 
        DropdownClass $dropdown,
    ){
        $this->pap_codes = $pap_codes;
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
    
        switch($request->option){     
            case 'lists':
                return $this->pap_codes->lists($request);
            break;  

            case 'mode_of_procurements':
                return $this->dropdown->mode_of_procurements($request);
            break; 
            
            default:
                return inertia('Modules/FAIMS/Procurement/Libraries/PAPCodes/Lists');
                break;
                  
        }   
    }

    public function store(Request $request) {
        $result = $this->handleTransaction(function () use ($request) {
            return $this->pap_codes->save($request);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);

    }

    
    public function update(Request $request , $id) {
        $result = $this->handleTransaction(function () use ($request ,$id) {
            return $this->pap_codes->update($request, $id);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);

    }


    

    
}
