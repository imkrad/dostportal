<?php

namespace App\Models\FAIMS\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPAPCode extends Model
{
    use HasFactory;
    protected $table = 'list_pap_codes';
    protected $fillable = [
        'title',
        'code',
        'allocated_budget',
        'mode_of_procurement_id'
    ];

    public function mode_of_procurement()
    {
        return $this->belongsTo('App\Models\FAIMS\Libraries\ModeOfProcurement', 'mode_of_procurement_id' );
    }

}
