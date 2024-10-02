<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_request_number',
        'purchase_request_date',
        'request_sai_number',
        'purchase_request_purpose',
        'referrence_no',
        'division_id',
        'section_id',
        'requested_by',
        'approved_by',
        'supplier_id',
        'fund_cluster_id',
        'po_number',
        'pap_code',
        'status_id'
    ];



    public function section()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\Section', 'section_id');
    }

    public function requester()
    {
        return $this->belongsTo('App\Models\UserProfile', 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo('App\Models\UserProfile', 'approved_by');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\Supplier', 'supplier_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\PurchaseRequestStatus', 'status_id');
    }


    
    public static function generatePurchaseRequestNumber($date = null)
    {
        if ($date) {
            $year = date("y", strtotime($date));  // 'y' gives the last two digits of the year
            $month = date("m", strtotime($date));
        } else {
            $year = date("y", strtotime("now"));  // 'y' gives the last two digits of the year
            $month = date("m", strtotime("now"));
        }
    
        $count = self::whereYear('purchase_request_date', date("Y", strtotime($date ?? "now")))
                     ->whereMonth('purchase_request_date', $month)
                     ->count() + 1;
    
        return 'PR-' . $year . '-' . $month . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
