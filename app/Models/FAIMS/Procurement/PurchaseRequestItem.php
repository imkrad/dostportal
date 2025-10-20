<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_request_id',
        'purchase_request_number',
        'purchase_request_unit',
        'item_unit_type_id',
        'item_description',
        'item_quantity',
        'item_price',
        'status_id',    
    ];

    public function purchase_request()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\PurchaseRequest', 'purchase_request_id');
    }

    public function unit_type()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\UnitType', 'item_unit_type_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus','status_id');

    }

}
