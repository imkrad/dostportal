<?php

namespace App\Http\Controllers\Modules;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Hr\RateClass;

class HrController extends Controller
{
    use HandlesTransaction;

    public function __construct(RateClass $rate){
        $this->rate = $rate;
    }


    public function index(Request $request){
        switch($request->option){
            default:
                return inertia('Modules/Hr/Dashboard/Index'); 
        }   
    }

    public function show($code){
        switch($code){
            case 'employees':
                return inertia('Modules/Hr/Employees/Index');
            break;
            case 'rates':
                return inertia('Modules/Hr/Rates/Index',[
                    'salaries' => $this->rate->salaries()
                ]);
            break;
        }
    }
}
