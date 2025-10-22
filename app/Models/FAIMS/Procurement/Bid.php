<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_request_id',
        'supplier_id',
    ];

    public function purchase_request()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\PurchaseRequest', 'purchase_request_id' , 'id');
    }


    public function supplier()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\Supplier', 'supplier_id' , 'id');
    }


}
