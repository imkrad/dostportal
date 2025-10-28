<?php

namespace App\Services\FAIMS;

use App\Models\FAIMS\Libraries\AppType;
use App\Models\FAIMS\Libraries\EndUser;
use App\Models\FAIMS\Procurement\UnitType;
use App\Models\FAIMS\Procurement\Section;
use App\Models\FAIMS\Procurement\FundCluster;
use App\Models\FAIMS\Procurement\PurchaseRequestItem;
use App\Models\FAIMS\Procurement\Supplier;
use App\Models\FAIMS\Procurement\Bid;
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
        $data = PurchaseRequestItem::with('item_unit_type')->where('purchase_request_id',$id)
        ->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'item_no' => $item->item_no,
                'item_unit_type' => $item->item_unit_type,
                'item_description' => $item->item_description,
                'item_quantity' => $item->item_quantity,
                'item_unit_cost' => $item->item_unit_cost,
                'item_bid_price' => $item->item_bid_price,
                'total_cost' => $item->total_cost,
            ];
        });

        return $data;
    }

    public function bids($id)
    {
        // Eager-load relationships for efficiency
       $bids = Bid::with([
            'quotation_request.supplier',
            'bid_items.pr_item',
            'bid_items.bid_offer',
            'bid_items.status'
        ])
        ->where('purchase_request_id', $id)
        ->get();

        $data = $bids->map(function ($bid) {
            return [
                'bid_id' => $bid->id,
                'supplier' => $bid->quotation_request->supplier 
                    ? [
                        'id' => $bid->quotation_request->supplier->id,
                        'name' => $bid->quotation_request->supplier->name,
                    ]
                    : null,
                'bid_items' => $bid->bid_items->map(function ($bid_item) use ($bid) {
                    return [
                        'bid_item_id' => $bid_item->id,
                        'pr_item_id' => $bid_item->pr_item->id ?? null,
                        'item_no' => $bid_item->pr_item->item_no ?? null,
                        'item_unit_type' => $bid_item->pr_item->item_unit_type ?? null,
                        'item_description' => $bid_item->pr_item->item_description ?? null,
                        'item_unit_cost' => $bid_item->pr_item->item_unit_cost ?? null,
                        'item_quantity' => $bid_item->pr_item->item_quantity ?? null,
                        'total_cost' => $bid_item->pr_item->total_cost ?? null,
                        'item_bid_price' => $bid_item->bid_offer->item_bid_price ?? null,
                        'technical_proposal' => $bid_item->bid_offer->technical_proposal ?? null,
                        'delivery_term' => $bid_item->bid_offer->delivery_term ?? null,
                        'status_id' => $bid_item->status_id,
                        'status' => $bid_item->status,
                        // 👇 include supplier here
                        'supplier' => $bid->quotation_request->supplier 
                            ? [
                                'id' => $bid->quotation_request->supplier->id,
                                'name' => $bid->quotation_request->supplier->name,
                            ]
                            : null,
                    ];
                }),
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
        $data = User::with('user_roles' , 'profile')
        ->whereHas('user_roles', function ($query) {
            $query->where('role_id', 4);
        })->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->profile->firstname.' '.$item->profile->middlename[0].'. '.$item->profile->lastname.' '.$item->profile->suffix ,
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
