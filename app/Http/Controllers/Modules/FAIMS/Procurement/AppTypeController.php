<?php

namespace App\Http\Controllers\Modules\FAIMS\Procurement;

use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use App\Services\FAIMS\Procurement\AppTypeClass;
use App\Services\FAIMS\DropdownClass;
use App\Http\Controllers\Controller;

class AppTypeController extends Controller
{
    use HandlesTransaction;

    public function __construct(
        AppTypeClass $app_types, 
        DropdownClass $dropdown, 
    ){
        $this->app_types = $app_types;
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        
        switch($request->option){     
            case 'lists':
                return $this->app_types->lists($request);
            break;  

            case 'app_types':
                return $this->dropdown->app_types();
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
