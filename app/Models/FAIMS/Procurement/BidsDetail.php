<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidsDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_request_id',
        'pr_detail_id',
        'bids_id',
        'bids_unit',
        'bids_description',
        'bids_quantity',
        'bids_price',
        'bids_abc',
        'bids_unit_type_id',
        'remarks',
        'bids_count',
        'status_id',
    ];

    public function purchase_request()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\PurchaseRequest', 'purchase_request_id' , 'id');
    }

    public function pr_detail()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\PurchaseRequestDetail', 'pr_detail_id' , 'id');
    }

    public function unit_type()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\UnitType', 'bids_unit_type_id' , 'id');
    }

    public function bids()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\Bids', 'bids_id' , 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id' , 'id');
    }

}
