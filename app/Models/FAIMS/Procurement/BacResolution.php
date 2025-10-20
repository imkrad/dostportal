<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BacResolution extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_request_id',
        'bac_resolution_number',
        'body',
        'created_by_id',
    ];

    public function purchase_request()
    {
        return $this->belongsTo('App\Models\FAIMS\Procurement\PurchaseRequest', 'purchase_request_id');
    }

    public function created_by()
    {
        return $this->belongsTo('App\Models\UserProfile', 'created_by_id');
    }


    public static function generateBACResolutionNumber($date = null)
    {
        if ($date) {
            $year = date("y", strtotime($date));  // 'y' gives the last two digits of the year
            $month = date("m", strtotime($date));
        } else {
            $year = date("y", strtotime("now"));  // 'y' gives the last two digits of the year
            $month = date("m", strtotime("now"));
        }
    
        $count = self::whereYear('created_at', date("Y", strtotime($date ?? "now")))
                     ->whereMonth('created_at', $month)
                     ->count() + 1;
    
        return $year . '-' . $month . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

}
