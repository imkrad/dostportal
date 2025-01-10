<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bids extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_id',
        'purchase_request_id',
        'status_id',
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\Supplier', 'supplier_id' , 'id');
    }

    public function purchase_request()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\PurchaseRequest', 'purchase_request_id' , 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id' , 'id');
    }

    public function bids_details()
    {
        return $this->hasMany('App\Models\FAIMS\Procurement\BidsDetail');
    }

}
