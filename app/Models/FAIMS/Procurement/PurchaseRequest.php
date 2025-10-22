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
        'purchase_request_purpose',
        'purchase_request_title',
        'division_id',
        'section_id',
        'fund_cluster_id',
        'requested_by_id',
        'approved_by_id',
        'reawarded_count',
        'rebidded_count',
        'quotation_count',
        'status_id',
        'sub_status_id'
    ];

    public function section()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\Section', 'section_id');
    }

    public function fund_cluster()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\FundCluster', 'fund_cluster_id');
    }

    public function requested_by()
    {
        return $this->belongsTo('App\Models\User', 'requested_by_id')->with('profile');
    }

    public function approved_by()
    {
        return $this->belongsTo('App\Models\User', 'approved_by_id');
    }

    public function pap_codes()
    {
        return $this->hasMany('App\Models\FAIMS\Procurement\PRPAPCode', 'purchase_request_id')->with('pap_code.mode_of_procurement');;
    }
    
    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id');
    }

    public function sub_status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id');
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
