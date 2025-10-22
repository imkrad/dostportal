<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidOffer extends Model
{
    use HasFactory;
    protected $fillable = [
        'bid_item_id',
        'technical_proposal',
        'delivery_term',
    ];

    public function bid_item()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\BidItem', 'bid_item_id');
    }
}
