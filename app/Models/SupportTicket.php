<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListSystem extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    protected $fillable = [
        'requested_by',
        'request_number',
        'dv_number',
        'payee',
        'amount',
        'status',
        'problem_details',
        'corrective_action',
    ];
}
