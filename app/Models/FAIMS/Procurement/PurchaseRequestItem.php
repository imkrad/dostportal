<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_request_id',
        'item_unit_type_id',
        'item_description',
        'item_quantity',
        'item_unit_cost', 
        'total_cost' 
    ];

    public function purchase_request()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\PurchaseRequest', 'purchase_request_id');
    }

    public function unit_type()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\UnitType', 'item_unit_type_id');
    }


}
