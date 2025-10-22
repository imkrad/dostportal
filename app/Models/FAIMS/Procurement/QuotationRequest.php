<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'rfq_no',
        'submission_not_later_than',
        'purchase_request_purpose',
        'supplier_id',
        'supply_officer_id',
        'purchase_request_id',
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\Supplier', 'supplier_id');
    }

    public function supply_officer()
    {
        return $this->belongsTo('App\Models\UserProfile', 'supply_officer_id' , 'id');
    }

    public function purchase_request()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\PurchaseRequest', 'purchase_request_id', 'id');
    }


  public static function generateRFQNumber()
    {
        $now = now(); // Laravel's Carbon instance
        $year = $now->format('y'); // Last two digits of year
        $month = $now->format('m');

        // Count existing RFQs for this year and month
        $count = self::whereYear('created_at', $now->year)
                    ->whereMonth('created_at', $month)
                    ->count() + 1;

        $sequence = str_pad($count, 4, '0', STR_PAD_LEFT);

        return "PR-{$year}-{$month}-{$sequence}";
    }


}
