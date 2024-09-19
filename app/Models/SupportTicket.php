<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;
    protected $fillable = [
        'system_id',
        'requested_by',
        'request_number',
        'dv_number',
        'payee',
        'amount',
        'status',
        'problem_details',
        'corrective_action',
        'is_closed',
    ];


    public function requester()
    {
        return $this->belongsTo('App\Models\User', 'requested_by');
    }

    public function system()
    {
        return $this->belongsTo('App\Models\ListSystem', 'system_id');
    }
}
