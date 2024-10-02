<?php

namespace App\Services\FAIMS;

use App\Models\FAIMS\Procurement\UnitType;
use App\Models\FAIMS\Procurement\Section;
use App\Models\FAIMS\Procurement\FundCluster;
use App\Models\ListDropdown;
use App\Models\UserProfile;

class DropdownClass
{   
    public function unit_types(){
        $data = UnitType::get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name_long' => $item->name_long,
                'name_short' => $item->name_short,
            ];
        });
        return $data;
    }

    public function unit_type($request){
        $data = UnitType::where('id',$request->unit_type_id)
        ->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name_long' => $item->name_long,
                'name_short' => $item->name_short,
            ];
        });
        return $data;
    }

    public function divisions(){
        $data = ListDropdown::where('classification', 'Unit')
        ->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
            ];
        });
        return $data;
    }

    public function sections($request){
        $data = Section::where('division_id',$request->division_id)
        ->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'responsibility_center_code' => $item->responsibility_center_code,
            ];
        });
        return $data;
    }

    public function fund_clusters(){
        $data = FundCluster::get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
            ];
        });
        return $data;
    }

    public function requesters(){
        $data = UserProfile::get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->firstname.' '.$item->middlename[0].'. '.$item->lastname.' '.$item->suffix ,
            ];
        });
        return $data;
    }
    
    public function approvers(){
        $data = UserProfile::get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->firstname.' '.$item->middlename[0].'. '.$item->lastname.' '.$item->suffix ,
            ];
        });
        return $data;
    }
}
