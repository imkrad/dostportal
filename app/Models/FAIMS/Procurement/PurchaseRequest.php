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
        'purchase_request_title',
        'referrence_no',
        'division_id',
        'section_id',
        'requested_by',
        'approved_by',
        'supplier_id',
        'fund_cluster_id',
        'po_number',
        'quotation_count',
        'status_id'
    ];

    public function section()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\Section', 'section_id');
    }


    public function fundCluster()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\FundCluster', 'fund_cluster_id');
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
        return $this->belongsTo('App\Models\FAIMS\Libraries\Supplier', 'supplier_id');
    }


    public function pap_codes()
    {
        return $this->hasMany('App\Models\FAIMS\Procurement\PRPAPCode', 'purchase_request_id')->with('pap_code.mode_of_procurement');;
    }
    
    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id')
                    ->where('classification', 'purchase_request');
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

    public static function generateRFQNumber($date = null)
    {
        if ($date) {
            $year = date("Y", strtotime($date));  // 'y' gives the last two digits of the year
            $month = date("m", strtotime($date));
        } else {
            $year = date("Y", strtotime("now"));  // 'y' gives the last two digits of the year
            $month = date("m", strtotime("now"));
        }
    
        $count = self::whereYear('purchase_request_date', date("Y", strtotime($date ?? "now")))
                     ->whereMonth('purchase_request_date', $month)
                     ->count() + 1;
    
        return 'PR-' . $year . '-' . $month . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
