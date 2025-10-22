<?php

namespace App\Services\FAIMS;

use App\Models\FAIMS\Libraries\AppType;
use App\Models\FAIMS\Libraries\EndUser;
use App\Models\FAIMS\Procurement\UnitType;
use App\Models\FAIMS\Procurement\Section;
use App\Models\FAIMS\Procurement\FundCluster;
use App\Models\FAIMS\Procurement\PurchaseRequestItem;
use App\Models\FAIMS\Procurement\Supplier;
use App\Models\FAIMS\Procurement\BidItem;
use App\Models\FAIMS\Procurement\QuotationRequest;
use App\Models\FAIMS\Libraries\ListPAPCode;
use App\Models\FAIMS\Libraries\ModeOfProcurement;


use App\Models\User;
use App\Models\ListDropdown;
use App\Models\UserProfile;

class DropdownClass
{   

    public function app_types(){
        $data = AppType::get()->map(function ($item) {
            return [
                'value' => $item->id,
                'title' => $item->title,
            ];
        });
        return $data;
    }

    public function end_users(){
                      

        $data = EndUser::get()->map(function ($item) {
            return [
                'value' => $item->id,
                'title' => $item->title,
            ];
        });

        return $data;
    }

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

    public function list_sections(){
        $data = Section::get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'responsibility_center_code' => $item->responsibility_center_code,
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

    public function pap_codes(){
        $data = ListPAPCode::get()->map(function ($item) {
            return [
                'value' => $item->id,
                'code' => $item->code,
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

    public function pr_items($id)
    {
        $data = PurchaseRequestItem::with('unit_type')->where('purchase_request_id',$id)
        ->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'item_no' => $item->item_no,
                'item_unit_type' => $item->unit_type,
                'item_description' => $item->item_description,
                'item_quantity' => $item->item_quantity,
                'item_unit_cost' => $item->item_unit_cost,
                'item_bid_price' => $item->item_bid_price,
                'total_cost' => $item->total_cost,
            ];
        });

        return $data;
    }

    public function suppliers(){
        $data = Supplier::get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
            ];
        });
        return $data;
    }

    public function supply_officers(){
        $data = UserProfile::get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->firstname.' '.$item->middlename[0].'. '.$item->lastname.' '.$item->suffix ,
            ];
        });
        return $data;
    }


    public function bid_items($id)
    {
        $data = BidItem::with('bids_items', 'bids_items.unit_type')->where('purchase_request_id',$id)
        ->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'supplier' => $item->supplier,
                'bids_items' => $item->bids_items,
                'status' => $item->status,
            ];
        });

        return $data;
    }


    public function mode_of_procurements()
    {
        $data = ModeOfProcurement::get()->map(function ($item) {
            return [
                'value' => $item->id,
                'mode' => $item->mode,
            ];
        });


        return $data;
    }

    public function purchase_request_title($request){
        $data = ListPAPCode::findOrFail($request->id);
        return $data->title;
    }

    
    public function submission_not_later_than($request){
        $data = QuotationRequest::where('purchase_request_id', $request->id)->first();
        // get submission date
        return $data->submission_not_later_than;
    }

 

    

    
}
