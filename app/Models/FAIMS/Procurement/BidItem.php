<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'bid_id',
        'pr_item_id',
        'status_id',
    ];

    public function bid()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\Bid', 'bid_id' );
    }

    public function pr_item()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\PurchaseRequestItem', 'pr_item_id');
    }


    public function supplier()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\Supplier', 'supplier_id' , 'id');
    }


    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id' , 'id');
    }

}
