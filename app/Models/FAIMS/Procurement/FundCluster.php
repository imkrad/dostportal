<?php

namespace App\Models\FAIMS\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundCluster extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
    ];
}
