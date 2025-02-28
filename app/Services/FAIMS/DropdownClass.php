<?php

namespace App\Services\FAIMS;

use App\Models\FAIMS\Procurement\UnitType;
use App\Models\FAIMS\Procurement\Section;
use App\Models\FAIMS\Procurement\FundCluster;
use App\Models\FAIMS\Procurement\PurchaseRequestDetail;
use App\Models\FAIMS\Procurement\Supplier;
use App\Models\FAIMS\Procurement\Bids;
use App\Models\FAIMS\Procurement\QuotationRequest;
use App\Models\FAIMS\Libraries\ListPAPCode;
use App\Models\FAIMS\Libraries\ModeOfProcurement;


use App\Models\User;
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

    public function pr_details($id)
    {
        $data = PurchaseRequestDetail::with('unit_type')->where('purchase_request_id',$id)
        ->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'purchase_request' => $item->purchase_request,
                'unit_id' => $item->unit_id,
                'item_unit_id' => $item->unit_type['id'],
                'item_unit' => $item->unit_type['name_long'],
                'description' => $item->item_description,
                'quantity' => $item->item_quantity,
                'unit_cost' => $item->item_price,
                'item_bid_price' => $item->item_bid_price,
                'total_cost' => $item->total,
                'status' => $item->status,
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

    public function supplier_address($supplier_id){
        $data = Supplier::where('id',$supplier_id)->get()->map(function ($item) {
            return [
                'address' => $item->address
            ];
        });

        return $data;
    }


    public function bids($id)
    {
        $data = Bids::with('bids_details', 'bids_details.unit_type')->where('purchase_request_id',$id)
        ->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'supplier' => $item->supplier,
                'purchase_request' => $item->purchase_request,
                'bids_details' => $item->bids_details,
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
