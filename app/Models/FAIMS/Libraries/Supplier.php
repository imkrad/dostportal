<?php

namespace App\Models\FAIMS\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'mayors_permit_no',
        'tin',
        'philgeps_registration_no',
        'address',
        'contact',
        'code',
    ];

    public static function generateCode($date = null)
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
    
        return 'SUP-' . $year . '-' . $month . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
