<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;
use App\Services\Hr\UnitClass;
use App\Services\Hr\RateClass;
use App\Services\Hr\EmployeeClass;
use App\Services\Hr\DropdownClass;
use App\Http\Requests\HrRequest;
use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;

class HrController extends Controller
{
    use HandlesTransaction;

    public function __construct(RateClass $rate, EmployeeClass $employee, UnitClass $unit, DropdownClass $dropdown){
        $this->rate = $rate;
        $this->employee = $employee;
        $this->unit = $unit;
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        switch($request->option){
            case 'rates':
                return $this->rate->lists($request);
            break;
            case 'units':
                return $this->unit->lists($request);
            break;
            default:
                return inertia('Modules/Hr/Dashboard/Index'); 
        }   
    }

    public function show($code){
        switch($code){
            case 'employees':
                return inertia('Modules/Hr/Employees/Index',[
                    'dropdowns' => [
                        'positions' => $this->dropdown->positions(),
                        'bloods' => $this->dropdown->bloods(),
                        'employments' => $this->dropdown->employments(),
                        'maritals' => $this->dropdown->maritals()
                    ]
                ]);
            break;
            case 'units':
                return inertia('Modules/Hr/Units/Index',[
                    'dropdowns' => [
                        'units' => $this->dropdown->units()
                    ]
                ]);
            break;
            case 'rates':
                return inertia('Modules/Hr/Rates/Index',[
                    'dropdowns' => [
                        'salaries' => $this->dropdown->salaries(),
                        'specials' => $this->dropdown->specials(),
                        'administratives' => $this->dropdown->administratives()
                    ]
                ]);
            break;
        }
    }

    public function store(HrRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'rate':
                    return $this->rate->save($request);
                break;
                case 'unit':
                    return $this->unit->save($request);
                break;
            }
        });
        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function update(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'rate':
                    return $this->rate->update($request);
                break;
            }
        });
        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }
}
