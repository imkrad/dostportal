<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Dashboard\CroClass;
use App\Services\Dashboard\FinanceClass;
use App\Services\Laboratory\DropdownClass;

class DashboardController extends Controller
{
    public function __construct(){
   
    }

    public function index(Request $request){
        if(!\Auth::check()){
            return inertia('Auth/Login');
        }else{
            switch(\Auth::user()->role){
                case 'Administrator':
                    return inertia('Administrator/Dashboard/Index');
                break;
            }
        }
    }
}
