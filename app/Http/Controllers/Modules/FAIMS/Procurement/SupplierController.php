<?php

namespace App\Http\Controllers\Modules\FAIMS\Procurement;

use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use App\Services\FAIMS\Procurement\SupplierClass;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    use HandlesTransaction;

    public function __construct(
        SupplierClass $suppliers, 
    ){
        $this->suppliers = $suppliers;
    }

    public function index(Request $request){
    
        switch($request->option){     
            case 'lists':
                return $this->suppliers->lists($request);
            break;  
            
            default:
                return inertia('Modules/FAIMS/Procurement/Libraries/Suppliers/Lists');
                break;
                  
        }   
    }

    public function store(Request $request) {
        $result = $this->handleTransaction(function () use ($request) {
            return $this->suppliers->save($request);
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
            return $this->suppliers->update($request, $id);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);

    }


    

    
}
