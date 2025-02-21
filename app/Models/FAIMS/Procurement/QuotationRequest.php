<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'rfq_no',
        'submission_not_later_than',
        'purchase_request_purpose',
        'supplier_id',
        'supply_officer_id',
        'purchase_request_id',
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\Supplier', 'supplier_id' , 'id');
    }

    public function supply_officer()
    {
        return $this->belongsTo('App\Models\UserProfile', 'supply_officer_id' , 'id');
    }

    public function purchase_request()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\PurchaseRequest', 'purchase_request_id', 'id');
    }


    public static function generateRFQNumber($date = null)
    {
        if ($date) {
            $year = date("Y", strtotime($date));  // 'y' gives the last two digits of the year
            $month = date("m", strtotime($date));
        } else {
            $year = date("Y", strtotime("now"));  // 'y' gives the last two digits of the year
            $month = date("m", strtotime("now"));
        }
    
        $count = self::whereYear('date', date("Y", strtotime($date ?? "now")))
                     ->whereMonth('date', $month)
                     ->count() + 1;
    
        return $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
