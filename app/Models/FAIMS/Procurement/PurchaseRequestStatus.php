<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestStatus extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'color',
        'code',
    ];


    
}
