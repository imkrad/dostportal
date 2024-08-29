<?php

namespace App\Services\Hr;

use App\Models\ListData;
use App\Models\ListSalary;
use App\Models\ListDropdown;
use App\Models\ListPosition;

class DropdownClass
{   
    public function positions(){
        $data = ListPosition::with('special','administrative','salary')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'special' => ($item->special) ? $item->special->name : '-',
                'administrative' => ($item->administrative) ? $item->administrative->name : '-',
                'grade' => $item->salary->grade,
                'salary' => $item->salary->amount
            ];
        });
        return $data;
    }

    public function units(){
        $data = ListDropdown::where('Classification','Unit')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'others' => $item->others
            ];
        });
        return $data;
    }

    public function specials(){
        $data = ListData::where('type','Special Order')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
            ];
        });
        return $data;
    }

    public function administratives(){
        $data = ListData::where('type','Administrative Order')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
            ];
        });
        return $data;
    }

    public function salaries(){
        $data = ListSalary::all()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => 'Salary Grade '.$item->grade.' - '.$item->amount,
                'amount' => $item->amount,
                'grade' => $item->grade
            ];
        });
        return $data;
    }

    public function bloods(){
        $data = ListData::where('type','Blood Type')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
            ];
        });
        return $data;
    }

    public function employments(){
        $data = ListData::where('type','Employment Status')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
            ];
        });
        return $data;
    }

    public function maritals(){
        $data = ListData::where('type','Marital Status')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
            ];
        });
        return $data;
    }
}
