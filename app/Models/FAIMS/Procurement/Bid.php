<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_request_id',
        'quotation_request_id',
    ];

    public function purchase_request()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\PurchaseRequest', 'purchase_request_id');
    }


    public function quotation_request()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\QuotationRequest', 'quotation_request_id');
    }

    
    public function bid_items()
    {
        return $this->hasMany('App\Models\FAIMS\Procurement\BidItem', 'bid_id');
    }



}
