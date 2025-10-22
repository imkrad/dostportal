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
        'year',
        'app_type_id',
        'mode_of_procurement_id'
    ];

    public function app_type()
    {
        return $this->belongsTo('App\Models\FAIMS\Libraries\AppType', 'app_type_id' );
    }

    public function mode_of_procurement()
    {
        return $this->belongsTo('App\Models\FAIMS\Libraries\ModeOfProcurement', 'mode_of_procurement_id' );
    }

    public function end_users()
    {
        return $this->hasMany('App\Models\FAIMS\Libraries\PAPCodeEndUser', 'pap_code_id' );
    }


}
