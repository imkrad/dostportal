<?php

namespace App\Models\FAIMS\Libraries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PAPCodeEndUser extends Model
{
    use HasFactory;
    protected $table = 'pap_code_end_users';
    protected $fillable = [
        'pap_code_id',
        'end_user_id'
    ];

    public function pap_code()
    {
        return $this->belongsTo('App\Models\FAIMS\Libraries\ListPAPCode', 'pap_code_id' );
    }

    public function end_user()
    {
        return $this->belongsTo('App\Models\FAIMS\Libraries\EndUser', 'end_user_id' );
    }

}
