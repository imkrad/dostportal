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
}
